<?php include_once("../globalconfig.php"); ?>
<style>
 /*931 */
 .lft-cn{
                float:none !important;
                width:100%;
            }
            .filter-key-result {
                display:inline-flex !important;
                width:100%;
            }
            .result-title li{
                word-break: break-all ;
            }
            #lepopup-wrap {
    top: 170px !important;
}
</style>
<?php
      /*echo '<pre>';
      print_r($_POST);
      echo '</pre>';*/
        ob_start();
        $drilldownflag=1;
        
        // Guided tour attributes 
        $tourIndustryId="24";
        $tourIndustryName="Education";
        // End of Tour Attributes
        $popup_search = 0;
        $companyId=632270771;
        $compId=0;
        require_once("maconfig.php");
        require_once("../dbconnectvi.php");//including database connectivity file
        $Db = new dbInvestments();
        $videalPageName="MAMA";
        include_once('machecklogin.php');
        function emptyhiddendata(){
            $_POST['total_inv_deal']="";
            $_POST['total_inv_amount']="";
            $_POST['total_inv_inr_amount']="";
            $_POST['total_inv_company']="";
        }
//         include("../survey/survey.php");
          if( isset( $_POST[ 'pe_checkbox' ] ) && !empty( $_POST[ 'pe_checkbox' ] ) ) {
        $pe_checkbox = explode( ',', $_POST[ 'pe_checkbox' ] );
        
        if(count($pe_checkbox)<= 0 && !empty($_POST[ 'uncheckRows' ])){
            
            $pe_checkbox = explode( ',', $_POST[ 'uncheckRows' ] );
        }
    } else {
        $pe_checkbox = '';
    }
    
    if (isset($_POST[period_flag])) {
        $period_flag = $_POST['period_flag'];
    } else {
        $period_flag = 1;
    }
    
    if( isset( $_POST[ 'pe_checkbox_enable' ] ) && !empty( $_POST[ 'pe_checkbox_enable' ] ) ) {
        
        $pe_checkbox_enable = explode( ',', $_POST[ 'pe_checkbox_enable' ] );
        
        if(count($pe_checkbox_enable)<= 0 && !empty($_POST[ 'checkedRow' ])){
            
            $pe_checkbox_enable = explode( ',', $_POST[ 'checkedRow' ] );
        }
        
        $pe_checkbox = '';
    } else {
        $pe_checkbox_enable = '';
        
    }
    if( isset( $_POST[ 'pe_hide_companies' ] ) ) {
        $pe_hide_companies = explode( ',', $_POST[ 'pe_hide_companies' ] );
        $peHideFlagCh = true;
    }
     if( isset( $_POST[ 'pe_amount' ] ) && !empty( $_POST[ 'pe_amount' ] ) ) {
        $pe_amount = $_POST[ 'pe_amount' ];
    }
    if( isset( $_POST[ 'pe_company' ] ) ) {

        $pe_company = $_POST[ 'pe_company' ];
        //alert($pe_company);
        $peEnableFlag = true;
    }
    
    //====================jagadeesh rework===================================================
    
    if( isset( $_POST[ 'pe_hide_companies' ] ) ) {
        $pe_hide_companies = explode( ',', $_POST[ 'pe_hide_companies' ] );
        $peHideFlagCh = true;
    }
    
    
    
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] : 1; //get trendview type
        $getyear = $_REQUEST['y'];
        $getsy = $_REQUEST['sy'];
        $getey = $_REQUEST['ey'];
        $getindus = $_REQUEST['i'];
        $getstage = $_REQUEST['s'];
        $getinv = $_REQUEST['inv'];
        $getreg = $_REQUEST['reg'];
        $getrg = $_REQUEST['rg'];
        if(trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
        {
            $_POST['industry']="";
            $_POST['stage']="--";
            $_POST['dealtype']="--";
            $_POST['targetcompanytype']="--";
            $_POST['acquirercompanytype']="--";
            $_POST['invrangestart']="--";
            $_POST['invrangeend']="--";
            $_POST['targetCountry']="";
            $_POST['acquirerCountry']="";
        }
           
        if($getyear !='')
        {
            $getdt1 = $getyear.'-01-01';
            $getdt2 = $getyear.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getsy !='' && $getey !='')
        {
            $getdt1 = $getsy.'-01-01';
            $getdt2 = $getey.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getindus !='')
        { 
            $isql="select industryid,industry from industry where industry='".$getindus."'" ;
            $irs=mysql_query($isql);
            $irow=mysql_fetch_array($irs);
            $geti = $irow['industryid'];
            $getind=" and pec.industry=".$geti; 
        }
         if($getstage !='')
        { 
            $ssql="select StageId,Stage from stage where Stage='".$getstage."'" ;
            $srs=mysql_query($ssql);
            $srow=mysql_fetch_array($srs);
            $gets = $srow['StageId'];
            $getst=" and pe.StageId=" .$gets;
        }
        if($getinv !='')
        {
            $invsql = "select InvestorType,InvestorTypeName from investortype where Hide=0 and InvestorTypeName='".$getinv."'" ;
            $invrs = mysql_query($invsql);
            $invrow=mysql_fetch_array($invrs);
            $getinv = $invrow['InvestorType'];
            $getinvest = " and pe.InvestorType = '".$getinv ."'";
        }
        if($getreg!='')
        {
            if($getreg =='empty')
            {
                $getreg='';
            }
            else
            {
                $getreg;
            }
            $regsql = "select RegionId,Region from region where Region='".$getreg."'" ;
            $regrs = mysql_query($regsql);
            $regrow=mysql_fetch_array($regrs);
            $getreg = $regrow['RegionId'];
            $getregion = " and pec.RegionId  =".$getreg." and pec.RegionId IS NOT NULL";
        }
        if($getrg!='')
        {
            if($getrg == '200+')
            {
                $getrange = " and pe.amount > 200";
            }
            else
            {
                $range = explode("-", $getrg);
                $getrange = " and pe.amount > ".$range[0]." and pe.amount <= ".$range[1]."";
            }

        }
        
        $resetfield=$_POST['resetfield'];//reset post value
        
        //condition for date parameter. Both get and post value
        if(isset($_POST['popup_select'])){ 
            $month1=01; 
            $year1 = 2005;
            $month2= date('n');
            $year2 = date('Y');    
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";        
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'GET')
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
            }elseif($_GET['search']!=''){
                $month1=01; 
                $year1 = 2004;
                $month2= date('n');
                $year2 = date('Y');

                $dt1 = $year1."-".$month1."-01";
                $dt2 = $year2."-".$month2."-31";
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
            
            $searchallfield=trim($_GET['search']);
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            $searchallfield=trim($_POST['searchallfield']);
            if($resetfield=="period")
            {
             $month1= date('n'); 
             $year1 = date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }elseif (($resetfield=="searchallfield") ||($resetfield=="keywordsearch")||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= date('n'); 
             $year1 = date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['searchKeywordLeft'])!=""  || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" 
                    || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" || (count($_POST['industry']) > 0) || (count($_POST['targetCountry']) > 0) || (count($_POST['acquirerCountry']) > 0) 
                    || ($_POST['targetcompanytype']!="--") || ($_POST['acquirercompanytype']!="--") || ($_POST['invrangestart']!="--")
                    || ($_POST['invrangeend']!="--")|| ($_POST['exitstatus']!="--") ||  (count($_POST['valuations']) > 0))
            {
            
             //   if(trim($_POST['searchallfield'])!=""){
                 
                    if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                        
                        if($period_flag == 2){
                            $month1 = $_POST['month1'];
                            $year1 = $_POST['year1'];
                        } else {
                            $month1=01;
                            $year1 = 2004;
                        }
                        
                        $month2= date('n');
                        $year2 = date('Y');
                    }else{
                        $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                    }
            //    }
//                if(trim($_POST['investorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['acquirersearch'])!="" || trim($_POST['advisorsearch_legal'])!="" || trim($_POST['advisorsearch_trans'])!=""){
//                    $month1=01; 
//                    $year1 = 2004;
//                    $month2= date('n');
//                    $year2 = date('Y');
//                }
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
        }
        
        $TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin,Student from dealcompanies as dc ,malogin_members as dm where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
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
        else
        {
           $hideIndustry="";     
        }
       
        $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
       
        if ($totalrs = mysql_query($getTotalQuery))
        {
            While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
            {
                         $totDeals = $myrow["totaldeals"];
                         $totDealsAmount = $myrow["totalamount"];
            }
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
        
        if($resetfield=="searchallfield")
        { 
            $_POST['searchallfield']="";
            $_POST['searchKeywordLeft']="";
            $searchallfield="";
            emptyhiddendata();
        }
        else 
        {
            if($_POST['searchallfieldHide'] !=''){
                $searchallfield ='';
            }else if(isset($_POST['searchKeywordLeft']) && $_POST['searchKeywordLeft'] !=''){
               $searchallfield=trim($_POST['searchKeywordLeft']);             
            }else if(isset($_POST['searchallfield']) && trim($_POST['searchallfield']) !=''){
            $searchallfield=trim($_POST['searchallfield']);
            }else if($_POST['popup_select'] == '' && $_POST['popup_keyword'] !=''){
                $searchallfield=trim($_POST['popup_keyword']);
            }
            if($searchallfield != "")
                        {
               
                            $_POST['companyId'] = "";   $_POST['companysearch']="";
                            $_POST['assectorsearch'] = "";  $_POST['sectorsearch']="";
                            $_POST['keywordsearch'] = "";  $_POST['acquireId']=""; 
                            
                            $_POST['advisorsearch_legal'] = "";  
                            $_POST['advisorsearch_trans'] = "";
                        }
        }
        $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
        
        //show deals by POST values
        if($resetfield=="keywordsearch")
        { 
            $_POST['keywordsearch']="";
            $_POST['acquireId']="";
            $acquirersearch="";
            $acquirersearchhidden="";
            $acquirerId="";
        }
        else 
        {
           $acquirersearch = $_POST['keywordsearch'];
           $acquirersearchhidden=trim($_POST['keywordsearch']);
           if($acquirersearch!=''){
                $searchallfield='';
            $acquirerId=trim($_POST['acquireId']);
            }else{
                if(isset($_POST['popup_select']) && $_POST['popup_select']=='acquirers'){
                    $acquirersearch = $keyword=trim($_POST['popup_keyword']);
                     $keywordhidden=trim($_POST['popup_keyword']);
                     $acquirerId = trim(implode(',', $_POST['search_multi']));
                }else{
                    $acquirersearch = $keyword=$keywordhidden='';
        }
            }
             $sql_investorauto_sug = "select  AcquirerId as id,Acquirer as name from acquirers where AcquirerId IN($acquirerId) order by AcquirerId";
            
             $sql_investorauto_sug_Exe=mysql_query($sql_investorauto_sug);
            // print_r($getInvestorSql_Exe);
             $response =array(); 
             $invester_filter =$trend_inv_qry = $inv_qry ="";
            $i = 0;
             While($myrow = mysql_fetch_array($sql_investorauto_sug_Exe,MYSQL_BOTH)){

               $response[$i]['id']= $myrow['id'];
               $response[$i]['name']= $myrow['name'];
               if($i!=0){

                   $invester_filter.=",";
               }
                  $invester_filter.=$myrow['name'];
                  $trend_inv_qry .= " peinv.investor LIKE '".$myrow['name']."' or ";
                  $inv_qry .= " REinv.investor LIKE '".$myrow['name']."' or ";
              $i++;

             }
             $trend_inv_qry = trim($trend_inv_qry, ' or ');
             $inv_qry = trim($inv_qry, ' or ');
        }
        $keywordhidden =ereg_replace(" ","_",$keywordhidden);
        $acquirersearchhidden =ereg_replace(" ","_",$acquirersearchhidden);
        if($resetfield=="sectorsearch")
        { 
            $_POST['sectorsearch']="";
            $_POST['assectorsearch']="";
            $targetsectorsearch="";
        }
        else 
        { 
            $targetsectorsearch=stripslashes(trim($_POST['sectorsearch']));
            if($targetsectorsearch!=''){
                $searchallfield='';
            }else if(isset($_POST['popup_select']) && $_POST['popup_select']=='sector'){
                $targetsectorsearch=trim(implode(',', $_POST['search_multi']));//trim($_POST['popup_keyword']);
            } 
        }
        $sectorsearchhidden=ereg_replace(" ","_",$targetsectorsearch);
        if($resetfield=="companysearch")
        { 
            $_POST['companysearch']="";
            $_POST['companyId']="";
            $targetcompanysearch="";
            $targetCompanyId="";
        }
        else 
        {
            $targetcompanysearch=$_POST['companysearch'];
            if($targetcompanysearch!=''){
                $searchallfield='';
             $targetCompanyId=trim($_POST['companyId']);
            }else if(isset($_POST['popup_select']) && $_POST['popup_select']=='company'){
                $targetcompanysearch=trim(implode(',', $_POST['search_multi']));//trim($_POST['popup_keyword']);
                $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($targetcompanysearch)";
            
                 $sql_company_Exe=mysql_query($sql_company);
                 $company_filter=$trend_com_qry = "";
                 $response =array();
                $i = 0;
                 While($myrow = mysql_fetch_array($sql_company_Exe,MYSQL_BOTH)){

                    $response[$i]['id']= $myrow['id'];
                    $response[$i]['name']= $myrow['name'];
                   if($i!=0){

                       $company_filter.=",";
        }
                      $company_filter.=$myrow['name'];
                    $trend_com_qry .= " pec.companyname LIKE '".$myrow['name']."' or ";
                  $i++;
        
        }
                $trend_com_qry = trim($trend_com_qry, ' or ');
                $targetCompanyId=trim($targetcompanysearch);
        }
        }
        $companysearchhidden=ereg_replace(" ","_",$targetcompanysearch);
        
        if($resetfield=="keywordsearch")
        { 
            $_POST['keywordsearch']="";
            $targetaquirersearch="";
        }
        else 
        {
            $targetaquirersearch=$_POST['keywordsearch'];
            if($targetaquirersearch!=''){
                $searchallfield='';
            }else{
                if(isset($_POST['popup_select']) && $_POST['popup_select']=='acquirers'){
                    $targetaquirersearch=trim($_POST['popup_keyword']);
        }
        }
        }
        $aquirersearchhidden=ereg_replace(" ","_",$targetaquirersearch);
        if($resetfield=="advisorsearch_legal")
        { 
            $_POST['advisorsearch_legal']="";
            $advisorsearchstring_legal="";
        }
        else 
        {
            $advisorsearchstring_legal=trim($_POST['advisorsearch_legal']);
            $advisorsearchstringArray = explode( ',', $advisorsearchstring_legal );
            if($advisorsearchstring_legal!=''){
                $searchallfield='';
                foreach ($advisorsearchstringArray as $advisorsearchstringVal) {
                    $legalWhereCond .= " cia.cianame LIKE '".$advisorsearchstringVal."' or ";
                }
                
            }else if(isset($_POST['popup_select']) && $_POST['popup_select']=='legal_advisor'){
                //$advisorsearchstring_legal_id=trim($_POST['popup_keyword']);
                $advisorsearchstring_legal_id=trim(implode(',', $_POST['search_multi']));
                $advisorsql= "select cianame from advisor_cias where CIAId IN ($advisorsearchstring_legal_id)";

                if ($advisorrs = mysql_query($advisorsql))
                {
                    $li = 0;
                    While($myrow=mysql_fetch_array($advisorrs, MYSQL_BOTH))
                    {
                        if( $li != 0 ) {
                            $advisorsearchstring_legal .= ',';
                            $legal_filter .= ',';
                        }
                            $legal_filter .= $myrow["cianame"];
                            $advisorsearchstring_legal .= $myrow["cianame"];
                            $legalWhereCond .= " cia.cianame LIKE '".$myrow['cianame']."' or ";
                            $li++;
        }
        
        }
            }
            $legalWhereCond = trim($legalWhereCond,' or ');
        }
        $advisorsearchhidden_legal=ereg_replace(" ","_",$advisorsearchstring_legal);
        if($resetfield=="advisorsearch_trans")
        { 
            $_POST['advisorsearch_trans']="";
            $advisorsearchstring_trans="";
        }
        else 
        {
            $advisorsearchstring_trans=trim($_POST['advisorsearch_trans']);
            $advisorsearchstring_transArray = explode( ',', $advisorsearchstring_trans );
            if($advisorsearchstring_trans!=''){
                $searchallfield='';
                foreach ($advisorsearchstring_transArray as $advisorsearchstringTransVal) {
                    $transWhereCond .= " cia.cianame LIKE '".$advisorsearchstringTransVal."' or ";
                }
            }else if(isset($_POST['popup_select']) && $_POST['popup_select']=='transaction_advisor'){
                //$advisorsearchstring_trans_id=trim($_POST['popup_keyword']);
                $advisorsearchstring_trans_id=trim(implode(',', $_POST['search_multi']));
                $advisorsql= "select cianame from advisor_cias where CIAId IN ($advisorsearchstring_trans_id)";

                if ($advisorrs = mysql_query($advisorsql))
                {
                    $ti = 0;
                    While($myrow=mysql_fetch_array($advisorrs, MYSQL_BOTH))
                    {
                        if( $ti != 0 ) {
                            $transaction_filter .= ',';
                            $advisorsearchstring_trans .= ',';
                        }
                            $transaction_filter .= $myrow["cianame"];
                            $advisorsearchstring_trans .= $myrow["cianame"];
                            $transWhereCond .= " cia.cianame LIKE '".$myrow['cianame']."' or ";
                        $ti++;
        }
        }
            }
            $splitStringAcquirer=explode(" ", $advisorsearchstring_trans);
            $splitString1Acquirer=$splitStringAcquirer[0];
            $splitString2Acquirer=$splitStringAcquirer[1];
            $stringToHideAcquirer_legal=$splitString1Acquirer. "+" .$splitString2Acquirer;

            $transWhereCond = trim($transWhereCond,' or ');

        }
        $advisorsearchhidden_trans=ereg_replace(" ","_",$advisorsearchstring_trans);

       //Refine POST values
        if($resetfield=="industry")
        { 
            $_POST['industry']="";
            $industry="--";
        }
        else 
        {
           $industry=$_POST['industry'];
            if($industry!='--' && count($industry) >0){
                $searchallfield='';
        }
        }
        if($resetfield=="dealtype")
        { 
            $_POST['dealtype']="";
            $dealtype = "--";
        }
        else 
        {
            $dealtype = $_POST['dealtype'];
            
        }
        if($_POST['dealtype'] &&  $dealtype!="" && count($dealtype)<3)
        {
            $booldeal=true;
        }
        else
        {
            $dealtype="--";
            $booldeal=false;
        }
        if($resetfield=="targetct")
        { 
            $_POST['targetcompanytype']="";
            $target_comptype="--";
        }
        else 
        {
            $target_comptype = trim($_POST['targetcompanytype']);
            if($target_comptype!='--' && $target_comptype!=''){
                $searchallfield='';
        }
        }
        if($resetfield=="acquirerct")
        { 
            $_POST['acquirercompanytype']="";
            $acquirer_comptype="--";
        }
        else 
        {
            $acquirer_comptype = trim($_POST['acquirercompanytype']);
            if(isset($_POST['acquirercompanytype']) && $acquirer_comptype!='--' && $acquirer_comptype!=''){
                $searchallfield='';
        }
        }
        if($resetfield=="range")
        { 
            $_POST['invrangestart']="";
            $_POST['invrangeend']="";
            $startRangeValue="--";
            $endRangeValue="--";
            $regionId="";
        }
        else 
        {
            $startRangeValue=$_POST['invrangestart'];
            $endRangeValue=$_POST['invrangeend'];
            if(isset($_POST['invrangestart']) && isset($_POST['invrangeend']) && $startRangeValue!="--" && $endRangeValue!="--"){
                $searchallfield='';
        }
        }
         $endRangeValueDisplay =$endRangeValue;
       if($resetfield=="tcountry")
        { 
            $_POST['targetCountry']="";
            $targetCountryId="--";
        }
        else 
        {
            $targetCountryId = $_POST['targetCountry'];
            if(count($_POST['targetCountry']) > 0 && $targetCountryId!="--"){
                $tcval = '';
                foreach($_POST['targetCountry'] as $tc){
                    if(trim($tc) !=''){
                        $tcval = 1;
                    }
                }
                if($tcval !=''){
                    $searchallfield='';
                }
            }
       }
        if($resetfield=="acountry")
        { 
            $_POST['acquirerCountry']="";
            $acquirerCountryId="--";
        }
        else 
        {
            $acquirerCountryId = $_POST['acquirerCountry'];
            if(isset($_POST['acquirerCountry']) && $acquirerCountryId!="--"){
                $acval = '';
                foreach($_POST['acquirerCountry'] as $ac){
                    if(trim($ac) !=''){
                        $acval = 1;
                    }
                }
                if($acval !=''){
                    $searchallfield='';
                }
       }
       }
       
        //echo "<br>Stge**" .$range;
       
        //valuation
        if($resetfield=="valuations")
        { 
            $_POST['valuations']="";
            $valuations="--";
            
        }
        else 
        {
            $valuations=$_POST['valuations'];
            $c=1;
            foreach($valuations as $v)
            {
                if($c > 1) { $coa=','; }
                $valuationstxt.= "$coa $v";
                $c++;
            }
            if($valuations!=''){
                $searchallfield='';
            }
            
        }

        if($_POST['valuations'] && $valuations!="")
        {
           $boolvaluations=TRUE;
           $valuationsql='';          
           $count = count($valuations);              
            if($count==1) { $valuationsql= "pe.$valuations[0]!=0 AND "; }
            else if ($count==2) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0   AND "; }
            else if ($count==3) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND "; }   
        }
        else
        {
            $boolvaluations=FALSE;
            $valuations="--";
            $valuationsql='';  
        }
        

        
        $whereind="";
        $wheredealtype="";
        $wheredates="";
        $whererange="";
        $wheretargetCountry="";
        $whereacquirerCountry="";
        $wheretargetcomptype="";
        $whereacquirercomptype="";
        
        //search label display values
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
   
        
        $dealCnt=0;
        $cnt=0;
        $dealCntSql="select count(MADealTypeId) as cnt from madealtypes";
        if($rsdealCnt=mysql_query($dealCntSql))
        {
          while($mydealcntrow=mysql_fetch_array($rsdealCnt,MYSQL_BOTH))
           {
             $dealCnt=$mydealcntrow["cnt"];
           }
        }
        if($booldeal==true)
        {
            foreach($dealtype as $typeId)
            {
                $stagesql= "select MADealType from madealtypes where MADealTypeId=$typeId";
                //echo "<br>**".$stagesql;
                if ($dealrs = mysql_query($stagesql))
                {
                    While($myrow=mysql_fetch_array($dealrs, MYSQL_BOTH))
                    {
                            $cnt=$cnt+1;
                            $dealtypevalue= $dealtypevalue. ",".$myrow["MADealType"] ;
                    }
                }
            }
           
            $dealtypevalue =substr_replace($dealtypevalue, '', 0,1);
            if($cnt==$dealCnt)
            {      
                $dealtypevalue="All DealType";
            }
        }
        else
             $dealtypevalue="All Type";
        
        if($target_comptype=="L")
        {   $target_comptype_display="Target Type-Listed";}
        elseif($target_comptype=="U")
        {   $target_comptype_display="Target Type-Unlisted";}
        else
        {    $target_comptype_display="";}


        if($acquirer_comptype=="L")
        $acquirer_comptype_display="Acquirer Type-Listed";
        elseif($acquirer_comptype=="U")
        $acquirer_comptype_display="Acquirer Type-Unlisted";
        else
        $acquirer_comptype_display="";
        if(count($targetCountryId) > 0)
                {
                    $targetCountrySql = $targetcountryvalue = '';
                    foreach($targetCountryId as $targetCountryIds)
                    {
                        $targetCountrySql .= " countryid='$targetCountryIds' or ";
                    }
                    $targetCountrySql = trim($targetCountrySql,' or ');
                    $countrySql= "select countryid,country from country where $targetCountrySql";

                if ($targetCountryrs = mysql_query($countrySql))
        {
                        While($myrow=mysql_fetch_array($targetCountryrs, MYSQL_BOTH))
                {
                                $targetcountryvalue.=$myrow["country"].',';
                        }
                }
                    $targetcountryvalue=  trim($targetcountryvalue,',');
                    $targetcountry_hide = implode($targetCountryId,',');
        }

        if($acquirerCountryId !="--" && (count($acquirerCountryId) > 0))
        {
            $acquirerCountrySql = $acquirercountryvalue = '';
            foreach($acquirerCountryId as $acquirerCountryIds)
            {
                $acquirerCountrySql .= " countryid='$acquirerCountryIds' or ";
            }
            $acquirerCountrySql = trim($acquirerCountrySql,' or ');
            $AcountrySql= "select countryid,country from country where $acquirerCountrySql ";
                if ($Acountryrs = mysql_query($AcountrySql))
                {
                        While($Amyrow=mysql_fetch_array($Acountryrs, MYSQL_BOTH))
                        {
                        $acquirercountryvalue.=$Amyrow["country"].',';
                        }
                }
            $acquirercountryvalue=  trim($acquirercountryvalue,',');
            $acquirercountry_hide = implode($acquirerCountryId,',');
        }
        
        
      
        
        if(($startRangeValue != "--")&& ($endRangeValue != ""))
        {
              if( ($startRangeValue==$endRangeValue) || ($startRangeValue > 0 && $endRangeValue == "--") )
                {
                        $endRangeValue=50000-0.01;
                        $endRangeValueDisplay=50000;
                        $rangeText=$myrow["RangeText"];

                }
                elseif($startRangeValue < $endRangeValue)
                {
                        //echo "<br>--Less than";
                        $startRangeValue=$startRangeValue;
                        $endRangeValue=$endRangeValue-0.01;
                        $rangeText=$myrow["RangeText"];
                }

               

        }
        elseif($startRangeValue == "--" && $endRangeValue > 0)
        {
                      //echo "<br>--Less than";
                        $startRangeValue=0;
                       
                        $endRangeValue=$endRangeValue-0.01;
                        $rangeText=$myrow["RangeText"];
                         
        
        }
        
        
        
            $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
            $splityear1=(substr($year1,2));
            $splityear2=(substr($year2,2));

           if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
            {   
               $sdatevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
               $edatevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                $wheredates1= "";
            }
             $datevalueDisplay1= $sdatevalueDisplay1;
             $datevalueDisplay2= $edatevalueDisplay2;
            
            /*$cmonth1= 01;
            $cyear1 = date('Y', strtotime(date('Y')." -1  Year"));
            $cmonth2= date('n');
            $cyear2 = date('Y');
            $csplityear1=(substr($cyear1,2));
            $csplityear2=(substr($cyear2,2));
            $sdatevalueCheck1 = returnMonthname($cmonth1) ." ".$csplityear1;
            $edatevalueCheck2 = returnMonthname($cmonth2) ."  ".$csplityear2;
            
            if($sdatevalueDisplay1 == $sdatevalueCheck1)
            {
                $datevalueCheck1=$sdatevalueCheck1;
                $datevalueCheck2=$edatevalueCheck2;
                $datevalueDisplay1=="";
                $datevalueDisplay2=="";
            }
            else
            {
                $datevalueCheck1=="";
                $datevalueCheck2=="";
                $datevalueDisplay1= $sdatevalueDisplay1;
                $datevalueDisplay2= $edatevalueDisplay2;
            }*/
             //print_r($_POST);
                if($_SESSION['MA_industries']!=''){

                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['MA_industries'].') ';
                }
    
         $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                    $orderby=""; $ordertype="";
                if(!$_POST || $targetcompanysearch != "" || $targetsectorsearch !='' || $acquirersearch !="" || $advisorsearchstring_legal !='' || $advisorsearchstring_trans !='') {
                    $industry = '--';
                    $$target_comptype = '--';
                    $acquirer_comptype = '--';
                    $targetCountryId = '--';
                    $acquirerCountryId = '--';
                    $startRangeValue = '--';
                    $endRangeValue = '--'; 
                    $valuations = array();
                   
                 }
                    if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
//                            $companysqlFinal = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
//               amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
//               pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide,dates
//                       FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
                         $companysqlFinal = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business, pe.Amount, pe.MAMAId, i.industry,
                        pec.countryId,c.country, pe.AcquirerId,ac.Acquirer,ac.countryid,pe.Asset,pe.hideamount,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate FROM mama AS pe, industry AS i,
                        pecompanies AS pec,country as c,acquirers as ac WHERE DealDate between '" . $getdt1. "' and '" . $getdt2 . "'and i.industryid=pec.industry 
                        and pec.PEcompanyID = pe.PECompanyID and c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId and pec.industry != 15 
                        ".$getind." ".$getst." ".$getinvest." ".$getregion." ".$getrange." " .$addVCFlagqry.$comp_industry_id_where. "  and pe.Deleted=0";
                        
                         $orderby="companyname";
                       $ordertype="asc";
                        }
                    else if(!$_POST){
                      
                         $yourquery=0;
                         $stagevaluetext="";
                         $industry=0;
                  
                         $dt1 = $year1."-".$month1."-01";
                         $dt2 = $year2."-".$month2."-31";
                       
                        $companysqlFinal = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business, pe.Amount, pe.MAMAId, i.industry,
                        pec.countryId,c.country, pe.AcquirerId,ac.Acquirer,AggHide,ac.countryid,pe.Asset,pe.hideamount,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate FROM mama AS pe, industry AS i,
                        pecompanies AS pec,country as c,acquirers as ac where DealDate between '" . $dt1. "' and '" . $dt2 . "' and i.industryid=pec.industry 
                        and pec.PEcompanyID = pe.PECompanyID and c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId and pec.industry != 15 
                        and pe.Deleted=0 ".$comp_industry_id_where;
                        
                       $orderby="companyname";
                       $ordertype="asc";
                    //echo "<br>all records" .$companysqlFinal;
            }
            elseif($searchallfield != "")
            {
                $yourquery=1;
                $industry=0;
                $stagevaluetext="";
                $datevalueDisplay1="";
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                
                                $searchExplode = explode( ' ', $searchallfield );
                                foreach( $searchExplode as $searchFieldExp ) {
                                   
                                    $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $investorLike .= "ac.Acquirer REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                }
                                
                                $companyLike = '('.trim($companyLike,'AND ').')';
                                $sectorLike = '('.trim($sectorLike,'AND ').')';
                                $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
                                $investorLike = '('.trim($investorLike,'AND ').')';
                                
                                //$tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%' or pec.tags REGEXP '[[.colon.]]$searchallfield$' or pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                                $tagsval =  $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike;                                    

                                $companysqlFinal ="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
                                pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate FROM
                                mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
                                WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                        AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry." AND ( $tagsval) $comp_industry_id_where ";
                                $orderby="companyname";
                                $ordertype="asc";
                                $popup_search=1;
                
            //echo "<bR>---searchallfield" .$companysqlFinal;
            }
            elseif ($targetcompanysearch != " " && $targetcompanysearch != "")
            {
                $yourquery=1;
                    $industry=0;
                $stagevaluetext="";
                $datevalueDisplay1="";
                            
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                            
                $companysqlFinal ="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
                                pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate FROM
                                mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
                            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                                AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.
                        " AND  (pec.PECompanyId IN ($targetCompanyId)) $comp_industry_id_where ";
                            
                            /*$companysqlFinal ="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
                                pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer,AggHide,DATE_FORMAT( DealDate, '%M-%Y' ) as dates,DealDate as DealDate FROM
                                mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                                AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.
                                " AND  (pec.companyname LIKE '%$targetcompanysearch%') "; */
                                 $orderby="companyname";
                                 $ordertype="asc";
                                 $popup_search=1;
            
                            //echo "<br> Company search--" .$companysqlFinal;
            }
                        elseif ($targetsectorsearch != " " && $targetsectorsearch != "")
            {
                             $sectorsearchArray = explode(",", str_replace("'","",$targetsectorsearch)); 
                                            $sector_sql = array(); // Stop errors when $words is empty
                                $sectors_filter = '';

                                            foreach($sectorsearchArray as $word){

                                                $word =trim($word);
//                                                $sector_sql[] = " sector_business LIKE '$word%' ";
                                                $sector_sql[] = " sector_business = '$word' ";
                                                $sector_sql[] = " sector_business LIKE '$word(%' ";
                                                $sector_sql[] = " sector_business LIKE '$word (%' ";
                                $sectors_filter.= $word.',';
                                            }
                            $sectors_filter = trim($sectors_filter,',');
                                            $sector_filter = implode(" OR ", $sector_sql);
                                            
                $yourquery=1;
                    $industry=0;
                $stagevaluetext="";
                $datevalueDisplay1="";
                            
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                if ($booldeal==true)
                                        {
                                            if(count($dealtype)<3)
                                            {
                                                foreach($dealtype as $typeId)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $wheredeal= $wheredeal. " pe.MADealTypeId=" .$typeId." or ";
                                                }

                                               
                                                    $wheredealtype = $wheredeal ;                           
                                                    $strlength=strlen($wheredealtype);
                                                    $strlength=$strlength-3;
                                                    //echo "<Br>----------------" .$wherestage;
                                                    $wheredealtype= substr ($wheredealtype , 0,$strlength);
                                                
                                                if($wheredealtype){   $wheredealtype ="and (".$wheredealtype.")";         }
                                                else{    $wheredealtype ="";     }
                                                
                                            }
                                        }
                            
                $companysqlFinal ="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
                                pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate FROM
                                mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
                                WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                        AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.$comp_industry_id_where.
                                " AND  ($sector_filter) $wheredealtype";
                                $orderby="companyname";
                                $ordertype="asc";
                                $popup_search=1;
            
                            //echo "<br> Company search--" .$companysqlFinal;
            }
            
            elseif($acquirersearch != " " && $acquirersearch != "")
            {
                            $yourquery=1;
                            $industry=0;
                            $stagevaluetext="";
                            $datevalueDisplay1="";
                            
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                            //moorthi
                            if($_SESSION['MA_industries']!=''){
                            
                                $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['MA_industries'].') ';
                            }
                            
                            $companysqlFinal ="SELECT peinv.PECompanyId, peinv.MAMAId,c.companyname, c.industry, i.industry, sector_business as sector_business,
                            peinv.Amount, peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate
                            FROM acquirers AS ac, mama AS peinv, pecompanies AS c, industry AS i
                            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   ac.AcquirerId = peinv.AcquirerId
                            AND c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and peinv.Deleted=0
                            AND c.industry !=15  AND (ac.AcquirerId IN ($acquirerId)) $comp_industry_id_where ";
                                /*$companysqlFinal ="SELECT peinv.PECompanyId, peinv.MAMAId,c.companyname, c.industry, i.industry, sector_business as sector_business,
                            peinv.Amount, peinv.AcquirerId, (SELECT GROUP_CONCAT( inv.Acquirer ORDER BY Acquirer='others') FROM mama as peinv_inv,acquirers as inv 
                                            WHERE peinv_inv.AcquirerId=inv.AcquirerId) as Acquirer,peinv.Asset,peinv.hideamount,AggHide,DATE_FORMAT( DealDate, '%M-%Y' ) as dates,DealDate as DealDate
                            FROM acquirers AS ac, mama AS peinv, pecompanies AS c, industry AS i
                            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   ac.AcquirerId = peinv.AcquirerId
                            AND c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and peinv.Deleted=0
                            AND c.industry !=15  AND (ac.AcquirerId IN ($acquirerId)) ";*/
                            
                            //
                            
                            /*
                            if(strlen($acquirersearch) >2){
                                $like='%'.$acquirersearch.'%';
                            }
                            else{
                                $like=$acquirersearch;
                            }
                            $companysqlFinal ="SELECT peinv.PECompanyId, peinv.MAMAId,c.companyname, c.industry, i.industry, sector_business as sector_business,
                            peinv.Amount, peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,AggHide,DATE_FORMAT( DealDate, '%M-%Y' ) as dates,DealDate as DealDate
                            FROM acquirers AS ac, mama AS peinv, pecompanies AS c, industry AS i
                            WHERE ac.AcquirerId = peinv.AcquirerId
                            AND c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and peinv.Deleted=0
                            AND c.industry !=15  AND ac.Acquirer LIKE '$like' "; */
                            $orderby="companyname";
                            $ordertype="asc";
                            $popup_search=1;
            
                           // echo "<br> acquire search--" .$companysqlFinal;
            }
            
            elseif($advisorsearchstring_legal!=" " && $advisorsearchstring_legal!="")
            {
                            $stagevaluetext="";
                            $yourquery=1;
                            $industry=0;
                            $datevalueDisplay1="";
                            
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                
                            if($_SESSION['MA_industries']!=''){

                                $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['MA_industries'].') ';
                            }
                                
                            $companysqlFinal ="(select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,peinv.Amount,
                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate
                            from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisoracquirer AS adac,acquirers as ac
                            where DealDate between '" . $dt1. "' and '" . $dt2 . "' and    c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId and
                            adac.CIAId=cia.CIAID and adac.MAMAId=peinv.MAMAId and AdvisorType='L' and ( " . $legalWhereCond . " ) $comp_industry_id_where )
                            UNION
                            (select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,peinv.Amount,
                            cia.CIAId,cia.Cianame,adcomp.CIAId AS CompCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate
                            from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisorcompanies AS adcomp,acquirers as ac
                            where DealDate between '" . $dt1. "' and '" . $dt2 . "' and c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId
                            and adcomp.CIAId=cia.CIAID and adcomp.MAMAId=peinv.MAMAId and AdvisorType='L' and (" . $legalWhereCond . ")  $comp_industry_id_where )";
                            $orderby="companyname";
                            $ordertype="asc";
                            $popup_search=1;
                                
            /*echo "<br>LEGAL -".$companysqlFinal;
            exit;*/
            }
            elseif($advisorsearchstring_trans!=" " && $advisorsearchstring_trans!="")
            {
                            $stagevaluetext="";
                            $yourquery=1;
                            $industry=0;
                            $datevalueDisplay1="";

                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";

                            if($_SESSION['MA_industries']!=''){

                                $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['MA_industries'].') ';
                            }

                            $companysqlFinal ="(select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,peinv.Amount,
                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate
                            from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisoracquirer AS adac,acquirers as ac
                            where DealDate between '" . $dt1. "' and '" . $dt2 . "' and    c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId
                            and adac.CIAId=cia.CIAID and adac.MAMAId=peinv.MAMAId and AdvisorType='T' and (". $transWhereCond .") $comp_industry_id_where )
                            UNION
                            (select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,peinv.Amount,
                            cia.CIAId,cia.Cianame,adcomp.CIAId AS CompCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate
                            from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisorcompanies AS adcomp,acquirers as ac
                            where DealDate between '" . $dt1. "' and '" . $dt2 . "' and c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId
                            and adcomp.CIAId=cia.CIAID and adcomp.MAMAId=peinv.MAMAId and AdvisorType='T' and (". $transWhereCond .") $comp_industry_id_where )";
                            $orderby="companyname";
                            $ordertype="asc";
                            $popup_search=1;
                        //echo "trans".$companysqlFinal;
            }

            elseif (($industry > 0) || ($target_comptype!="--") || ($acquirer_comptype!= "--") || ($startRangeValue == "--") || ($endRangeValue == "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")))
                {
                    $yourquery=1;

                                        $dt1 = $year1."-".$month1."-01";
                                        $dt2 = $year2."-".$month2."-31";
                    $companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                            sector_business as sector_business, pe.Amount, pe.MAMAId, i.industry,pec.countryId,c.country,
                            pe.AcquirerId,ac.Acquirer,ac.countryid,pe.Asset,pe.hideamount,AggHide,DATE_FORMAT( DealDate, '%b-%Y' ) as dates,DealDate as DealDate
                            FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac where    ".$valuationsql."     "; 
                                        
                                       
                                        
                                        if (count($industry) > 0)
                                        {
                                                     $iftest=$iftest.".1";
                                                    $indusSql = '';
                                                    foreach($industry as $industrys)
                                                    {
                                                        $indusSql .= " pec.industry=$industrys or ";
                                        }
                                                    $indusSql = trim($indusSql,' or ');
                                                    if($indusSql !=''){
                                                        $whereind = ' ( '.$indusSql.' ) ';
                                                    }
                            $qryIndTitle="Industry - ";
                        }
                    
                                       /* if ($dealtypeId!= "--")
                                        {
                                                $wheredealtype = " pe.MADealTypeId =" .$dealtypeId;
                                        }*/
                                        if ($booldeal==true)
                                        {
                                            if(count($dealtype)<3)
                                            {
                                                foreach($dealtype as $typeId)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $wheredeal= $wheredeal. " pe.MADealTypeId=" .$typeId." or ";
                                                }

                                               
                                                    $wheredealtype = $wheredeal ;                           
                                                    $strlength=strlen($wheredealtype);
                                                    $strlength=$strlength-3;
                                                    //echo "<Br>----------------" .$wherestage;
                                                    $wheredealtype= substr ($wheredealtype , 0,$strlength);
                                                
                                                if($wheredealtype){   $wheredealtype ="(".$wheredealtype.")";         }
                                                else{    $wheredealtype ="";     }
                                                
                                            }
                                        }
                                        if($target_comptype!="--" && $target_comptype!="")
                                                $wheretargetcomptype= " pe.target_listing_status='$target_comptype'";
                                        if($acquirer_comptype!="--" && $acquirer_comptype!="")
                                                $whereacquirercomptype= " pe.acquirer_listing_status='$acquirer_comptype'";
                                        if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--"))
                                        {

                                            if($startRangeValue == $endRangeValue)
                                            {
                                            //  echo "<br>**********";
                                                   // $whererange = " pe.Amount = ".$startRangeValue ." and pe.hideamount=0 ";
                                                    $whererange = " pe.Amount = ".$startRangeValue ;
                                            }
                                            else if($startRangeValue > 0 && $endRangeValue == "--"){
                                                
                                                //$whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
                                                $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ;   
                                             }
                                            elseif($startRangeValue < $endRangeValue)
                                            {
                                                   // $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
                                                    $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ;
                                            }
                                            elseif($endRangeValue="--")
                                            {
                                                    $endRangeValue=50000;
                                                    $endRangeValueDisplay=50000;
                                                   // $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
                                                    $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
                                            }

                                            $acrossDealsDisplay=1;
                                    }
                                    else if($startRangeValue==0 && $endRangeValue>0){
                                        // $whererange = " pe.Amount between  0.01 and ". $endRangeValue ." and pe.hideamount=0";
                                         $whererange = " pe.Amount between  0.01 and ". $endRangeValue ;
                                         
                                    }
                           
                                        if (count($targetCountryId) > 0)
                                        {
                                            $targetCountrySql = '';
                                            foreach($targetCountryId as $targetCountryIds)
                                            {
                                                if($targetCountryIds !=''){
                                                    $targetCountrySql .= " pec.countryId='$targetCountryIds' or ";
                                                }
                                            }
                                            $targetCountrySql = trim($targetCountrySql,' or ');
                                            if($targetCountrySql !=''){
                                                $wheretargetCountry = ' ( '.$targetCountrySql.' ) ';
                                            }
                                        }
                                        if(count($acquirerCountryId) > 0)
                                        {
                                            $acquirerCountrySql = '';
                                            foreach($acquirerCountryId as $acquirerCountryIds)
                                            {
                                                if($acquirerCountryIds !=''){
                                                    $acquirerCountrySql .= " ac.countryId='$acquirerCountryIds' or ";
                                                }
                                            }
                                            $acquirerCountrySql = trim($acquirerCountrySql,' or ');
                                            if($acquirerCountrySql !=''){
                                                $whereacquirerCountry = ' ( '.$acquirerCountrySql.' )  and c.countryid=ac.countryid';
                                            }
                                               // $whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' and c.countryid=ac.countryid";
                                        }
                                        if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                        {
                                                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                        }
                                            
                    if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                 $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
                    if (($wheredealtype != "") )
                                        {
                                                $companysql=$companysql . $wheredealtype . " and " ;
                                                $bool=true;
                                        }
                                        if (($wheretargetcomptype != ""))
                                        {
                                                $companysql=$companysql . $wheretargetcomptype . " and " ;
                                                $bool=true;
                                        }
                                        if($whereacquirercomptype !="")
                                        {
                                            $companysql=$companysql .$whereacquirercomptype. " and ";
                                             $bool=true;
                                        }  
                    if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
                                                $bool=true;
                                        }
                                        if (($wheretargetCountry != "") )
                                        {
                                                $companysql=$companysql .$wheretargetCountry . " and ";
                                                $bool=true;
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        $companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                            and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
                            and pec.industry != 15 and pe.Deleted=0 $comp_industry_id_where ";
                                        $orderby="companyname";
                                        $ordertype="asc";
                                        if($whereacquirerCountry != "")
                                        {

                                                $companysql=$companysql .$whereacquirerCountry . " and ";
                                                $companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                                and  ac.AcquirerId = pe.AcquirerId
                                                and pec.industry != 15 and pe.Deleted=0 $comp_industry_id_where ";
                                                $orderby="companyname";
                                                $ordertype="asc";
                                        }
                                        $popup_search=1;
                    
                                   //  echo    "refine".$companysqlFinal;
                }
                else
                {
                    echo "<br> INVALID DATES GIVEN ";
                    $fetchRecords=false;
                }
    //}
    //END OF POST
    
      $ajaxcompanysql=  urlencode($companysqlFinal);
       if($companysqlFinal!="" && $orderby!="" && $ordertype!="")
           $companysqlFinal = $companysqlFinal . " order by  DealDate desc,companyname asc "; 

    
    //INDUSTRY
    $industrysql="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
    
    //Company Sector
    $searchString="Undisclosed";
    $searchString=strtolower($searchString);

    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);

    $searchString2="Others";
    $searchString2=strtolower($searchString2);
    
    $addVCFlagqry="";
    $pagetitle="PE-backed Companies";

    $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                    FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                    WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
    ORDER BY pec.companyname";
    
    //Stage
    $stagesql = "select StageId,Stage from stage ";
    $topNav = 'Deals';
        $defpage=$vcflagValue;
        $investdef=1;
        $stagedef=1;
    include_once('maindex_search.php');
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active" id="openRefine">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php  include_once('marefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>  
</div>
    </div>
</td>

 <?php
        $exportToExcel=0;
        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student,dm.tour from dealcompanies as dc ,malogin_members as dm
        where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                        $studentOption=$trialrow["Student"];
                        $isTour=$trialrow["tour"];
                }
        }
        if($isTour==0 || $exportToExcel==0) { $tourautostart='ON'; }
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
         //echo    "refine".$companysqlFinal;
           if ($companyrsall = mysql_query($companysqlFinal))
            {
               //echo $companysqlFinal;
                $company_cntall = mysql_num_rows($companyrsall);
            } 
            if($company_cntall > 0)
            {
             $rec_limit = 50;
             $rec_count = $company_cntall;

            if( isset($_GET{'page'} ) )
            {
               $currentpage=$page;
               $page = $_GET{'page'} + 1;
               $offset = $rec_limit * $page ;
            }
            else
            {
                 $currentpage=1;
                 $page = 1;
                 $offset = 0;
            }
            // $ajaxcompanysql=  urlencode($companysql);
              $companysqlwithlimit=$companysqlFinal." limit $offset, $rec_limit";
             if ($companyrs = mysql_query($companysqlwithlimit))
             {
                 $company_cnt = mysql_num_rows($companyrs);
             }
                         //$searchTitle=" List of Deals";
            }

           if($company_cnt > 0)
           {
                        //$searchTitle=" List of Deals";
           }
           else
           {
                $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                $notable=true;
                writeSql_for_no_records($companysqlFinal,$emailid);
           }
 ?>


<td class="profile-view-left" style="width:100%;">
    

    <div class="result-cnt">
            <?php 
                        if ($accesserror==1){?>
                            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo GLOBAL_BASE_URL; ?>dd-subscribe.php">Click here</a></b></div>
                <?php
                        exit; 
                        } 
                ?>
        <div class="result-title">
        <div style="display: inline-flex;width:100%;">
            <div class="filter-key-result"> 
                <div style="float: left; margin: 20px 10px 0px 0px;font-size: 20px;">
                    <a  class="help-icon tooltip"><strong>Note</strong>
                      <span>
                          <img class="showtextlarge" src="img/callout.gif">
                          Target in () indicates sale of asset rather than the company. Target in { } indicates a minority stake acquisition. Such deals will not be counted for the aggregate data displayed.
                      </span>
                    </a> 
                </div>
                    <div class="lft-cn">                              
                            <?php if(!$_POST){?>
                                    
                               <ul class="result-select">
                                   <?php
                                   if($datevalueDisplay1!=""){  
                                    ?>
                                   <li> 
                                     <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                   </li>
                                    <?php }
                                    else if($datevalueCheck1 !="")
                                    {
                                    ?>
                                        <li style="padding:1px 10px 1px 10px;"> 
                                            <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                    <?php 
                                    }
                                if($stagevaluetext!=""){  ?>
                                          
                                              <li> 
                                                <?php echo $stagevaluetext;?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          
                                <?php }
                                 if (($getrangevalue!= "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$getrangevalue; ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if (($getinvestorvalue!= "")){ ?>
                                <li> 
                                    <?php echo $getinvestorvalue; ?><a  onclick="resetinput('invType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if (($getregionevalue != "")){ ?>
                                <li> 
                                    <?php echo $getregionevalue ; ?><a  onclick="resetinput('txtregion');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($getindusvalue!=""){  ?>

                                      <li> 
                                        <?php echo $getindusvalue;?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                <?php }
                                if($valuationstxt!=""){  ?>

                                <li> 
                                  <?php echo $valuationstxt;?><a  onclick="resetinput('valuations');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>

                              <?php } 
                                   
                                 if($drilldownflag ==0)
                                {
                                ?>
                                <li class="result-select-close"><a href="/ma/index.php"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                ?>
                               </ul>
                              <?php            
                              }
                                   else 
                                   {  ?> 
                                     
                            <ul class="result-select">
                                
                                <?php
                                if($drilldownflag ==0)
                                {
                                ?>
                                <li class="result-select-close"><a href="/ma/index.php"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                if($datevalueDisplay1!=""){  ?>
                                    <li> 
                                        <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } 
                                    else if($datevalueCheck1 !="")
                                    {
                                     ?>
                                     <li > 
                                        <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php
                                    }
                                    else if(isset($_POST['popup_select']) || trim($_POST['searchKeywordLeft'])!="" || trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
                                     {
       
                                     ?>
                                     <li > 
                                        <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php
                                    }
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=null){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($dealtype !="" && $dealtype !="--"){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $dealtypevalue; ?><a  onclick="resetinput('dealtype');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($target_comptype !="--" && $target_comptype !="") { $drilldownflag=0;?>
                                <li> 
                                    <?php echo $target_comptype_display; ?><a  onclick="resetinput('targetct');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($acquirer_comptype !="--" && $acquirer_comptype !=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $acquirer_comptype_display; ?><a  onclick="resetinput('acquirerct');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if ( ($startRangeValue!= "--" && $endRangeValue != "--" && $startRangeValue!= "" && $endRangeValue != "") || ($startRangeValue=="--" && $endRangeValue>0) ){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                
                                if($valuationstxt!=""){  ?>

                                <li> 
                                  <?php echo $valuationstxt;?><a  onclick="resetinput('valuations');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>

                              <?php } 
                                if($targetCountryId !="--" && $targetCountryId !="" && $targetcountryvalue !='') { $drilldownflag=0; ?>
                                <li class="countryht"> 
                                    <?php echo  $targetcountryvalue;?><a  onclick="resetinput('tcountry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($acquirerCountryId !="--" && $acquirerCountryId !="" && $acquirercountryvalue !='') { $drilldownflag=0; ?>
                                <li class="countryht"> 
                                    <?php echo  $acquirercountryvalue;?><a  onclick="resetinput('acountry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($targetcompanysearch!="" && $targetcompanysearch!=" "){ $drilldownflag=0; ?>
                                <li> 
                                    <?php if($company_filter !='') echo $company_filter; else  echo $targetcompanysearch?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($targetsectorsearch!="" && $targetsectorsearch!=" "){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo str_replace("'","",trim($targetsectorsearch));?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if(trim($acquirersearch)!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php if($invester_filter !='') echo $invester_filter; else echo $acquirersearch;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                               
                                if(trim($advisorsearchstring_legal)!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if(trim($advisorsearchstring_trans)!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                //print_r($_POST);
//                                $cl_count = count($_POST);
                                
                                ?>
                               
                                
                             </ul>
                                        <?php } ?>
        </div>
        </div>
        </div>
        <div class='result-rt-cnt'>
              
              <div class="result-count">
                <span class="result-amount"></span>
                <span class="result-amount-no" id="show-total-amount"></span> 
                <span class="result-no" id="show-total-deal"> Results Found</span> 
                   
                <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl ?>images/help.png" alt="" style="vertical-align:middle">
                    <span>
                    <img class="callout" src="<?php echo $refUrl ?>images/callout.gif">
                    <strong>Definitions
                    </strong>
                    </span>
                </a>
                <div class="title-links " id="exportbtn"></div>
            </div>      
              
        </div>
    </div>            
                                 
    <!--<div class="alert-note"><div class="alert-para">Note:  Target in () indicates sale of asset rather than the company. </div>
        <div class="alert-para">Target in { } indicates a minority stake acquisition. Such deals will not be counted for the aggregate data displayed. </div>
        <div class="title-links " id="exportbtn"></div>
    </div>           
                                     
    <div class="list-tab"><ul>
    <li class="active"><a class="postlink"   href="index.php?value=0"  id="icon-grid-view"><i></i> List  View</a></li>
    <?php
     $count=0;
                             While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                            {
                                    if($count == 0)
                                    {
                                             $comid = $myrow["MAMAId"];
                                            $count++;
                                    }
                            }
                            ?>
    <li><a id="icon-detailed-view" class="postlink" href="madealdetails.php?value=<?php echo $comid;?>" ><i></i> Detail View</a></li> 
    </ul></div>-->
      </div>    </div> 
                            <?php
                             $cos_array=$cos_array_Agg = $cos_array_Agg1= $cos_withdebt_array = array();$company_array=[];$company_array_comma='';
                             if($_SESSION['coscount']){ unset($_SESSION['coscount']); }
                             if($_SESSION['totalcount']){ unset($_SESSION['totalcount']); }
                             if($notable==false)
                             {
                        if ($company_cntall>0)
                          {
                            $hidecount=0;
                            mysql_data_seek($companyrsall,0);
                            
                            //Code to add PREV /NEXT
                            $icount = 0;
                            if ($_SESSION['resultId']) 
                                unset($_SESSION['resultId']); 
                                
                                                        While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                                                        {
                                                                if($myrow["Amount"]==0)
                                                                {
                                                                        $hideamount="";
                                                                        $amountobeAdded=0;
                                                                }
                                                                elseif($myrow["hideamount"]==1)
                                                                {
                                                                        $hideamount="";
                                                                        $amountobeAdded=0;

                                                                }
                                                                else
                                                                {
                                                                        $hideamount=$myrow["Amount"];
                                                                        $acrossDealsCnt=$acrossDealsCnt+1;
                                                                        $amountobeAdded=$myrow["Amount"];
                                                                        $cos_array[]=$myrow["PECompanyId"];
                                                                }
                                                                $cos_withdebt_array[]=$myrow["PECompanyId"];
                                                               
                                                                if($myrow["AggHide"]==1)
                                                                {
                                                                        $opensquareBracket="{";
                                                                        $closesquareBracket="}";
                                                                        $amtTobeDeductedforAggHide=$myrow["Amount"];
                                                                        $NoofDealsCntTobeDeducted=1;
                                                                        if($myrow["Amount"] != 0){
                                                                            $acrossDealsCnt=$acrossDealsCnt-1;
                                                                        }
                                                                       //echo $myrow["Amount"];
                                                                 }
                                                                else
                                                                {
                                                                        $opensquareBracket="";
                                                                        $closesquareBracket="";
                                                                        $amtTobeDeductedforAggHide=0;
                                                                        $NoofDealsCntTobeDeducted=0;
                                                                }
                                                                $_SESSION['resultId'][$icount++] = $myrow["MAMAId"];
                                                                $industryAdded = $myrow["industry"];
                                                                 /*$totalInv=$totalInv+1;
                                                                $totalAmount=$totalAmount+ $amountobeAdded;*/
                                                                $totalInv=$totalInv+1- $NoofDealsCntTobeDeducted;
                                                                $totalAmount=$totalAmount+ $myrow["Amount"]- $amtTobeDeductedforAggHide;

                                                                    }
                                                                $_SESSION['coscount'] =  count(array_count_values($cos_array)) ; 
                                                                $_SESSION['totalcount'] = $totalInv;
                                                              
                                                                foreach(array_count_values($cos_array) as $key=>$value){
                                                                    $company_array[]=$key;
                                                                }
                                                                $comp_count = count(array_count_values($cos_array));
                                                                $company_array_comma = implode(",",$company_array);
                                                                 

                                                        }
                                                        
                        ?>
            <a id="detailpost" class="postlink"></a>                            
                        <div class="view-table view-table-list">
                            <a id="detailpost" class="postlink"></a>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                               <?php  if($searchallfield != ''){
                            $uncheckRows = $_POST[ 'uncheckRows' ];
                            $pe_checkbox = explode( ',', $uncheckRows );
                            if(count($_POST[ 'uncheckRows' ]) > 0 && $_POST[ 'uncheckRows' ] !=""){
                                $allchecked='';
                            }else{
                                $allchecked='checked';
                            }
                            //echo count($_POST[ 'uncheckRows' ]);
                            if($_POST['full_uncheck_flag']!='' && $_POST['full_uncheck_flag'] ==1 ){

                                $allchecked='';
                            }
                            ?>
                             <th class=""><input type="checkbox" class="all_checkbox" id="all_checkbox" <?php echo $allchecked; ?>/></th>
                        <?php } ?>
                                <th style="width: 745px;" class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Target</th>
                                <th style="width: 625px;" class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                                <th style="width: 625px;" class="header <?php echo ($orderby=="Acquirer")?$ordertype:""; ?>" id="Acquirer">Acquirer</th>
                                <th style="width: 205px;" class="header <?php echo ($orderby=="DealDate")?$ordertype:""; ?>" id="DealDate">Date</th>
                                <th style="width: 153px;" class="header asc <?php echo ($orderby=="Amount")?$ordertype:""; ?>" id="Amount">Amount (US$M)</th>
                                </tr></thead>
                              <tbody id="movies">
                                        <?php
                                        if ($company_cnt>0)
                                          {
                                                $hidecount=0;
                                                mysql_data_seek($companyrs,0);
                                                       
                        While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                                {
                                                    $hideFlagset = 0;
                                                        $searchString4="PE Firm(s)";
                                                        $searchString4=strtolower($searchString4);
                                                        $searchString4ForDisplay="PE Firm(s)";

                                                        $searchString="Undisclosed";
                                                        $searchString=strtolower($searchString);

                                                        $searchString3="Individual";
                                                        $searchString3=strtolower($searchString3);

                                                        $companyName=trim($myrow["companyname"]);
                                                        $companyName=strtolower($companyName);
                                                        $compResult=substr_count($companyName,$searchString);
                                                        $compResult4=substr_count($companyName,$searchString4);

                                                        $acquirerName=$myrow["Acquirer"];
                                                        $acquirerName=strtolower($acquirerName);

                                                        $compResultAcquirer=substr_count($acquirerName,$searchString4);
                                                        $compResultAcquirerUndisclosed=substr_count($acquirerName,$searchString);
                                                        $compResultAcquirerIndividual=substr_count($acquirerName,$searchString3);

                                                        if($compResult==0)
                                                                $displaycomp=$myrow["companyname"];
                                                        elseif($compResult4==1)
                                                                $displaycomp=ucfirst("$searchString4");
                                                        elseif($compResult==1)
                                                                $displaycomp=ucfirst("$searchString");

                                                        if(($compResultAcquirer==0) && ($compResultAcquirerUndisclosed==0) && ($compResultAcquirerIndividual==0))
                                                                $displayAcquirer=$myrow["Acquirer"];
                                                        elseif($compResultAcquirer==1)
                                                                $displayAcquirer=ucfirst("$searchString4ForDisplay");
                                                        elseif($compResultAcquirerUndisclosed==1)
                                                                $displayAcquirer=ucfirst("$searchString");
                                                        elseif($compResultAcquirerIndividual==1)
                                                                $displayAcquirer=ucfirst("$searchString3");
                                                             $sector=$myrow["sector_business"];
                                                        if($myrow["Asset"]==1)
                                                        {
                                                                $openBracket="(";
                                                                $closeBracket=")";
                                                               
                                                        }
                                                        else
                                                        {
                                                                $openBracket="";
                                                                $closeBracket="";
                                                        }
                                                        
                                                        if($myrow["dates"]!="")
                                                        {
                                                                
                                                                $displaydate=$myrow["dates"];
                                                        }
                                                        else
                                                        {
                                                                $displaydate="-";
                                                        }
                                                        if($myrow["Amount"]==0)
                                                        {
                                                                $hideamount="";
                                                                $amountobeAdded=0;
                                                        }
                                                        elseif($myrow["hideamount"]==1)
                                                        {
                                                                $hideamount="";
                                                                $amountobeAdded=0;

                                                        }
                                                        else
                                                        {
                                                                $hideamount=$myrow["Amount"];
                                                               // $acrossDealsCnt=$acrossDealsCnt+1;
                                                                $amountobeAdded=$myrow["Amount"];
                                                        }
                                                        if($myrow["AggHide"]==1)
                                                        {
                                                                $opensquareBracket="{";
                                                                $closesquareBracket="}";
                                                                $hideFlagset = 1;
                                                                $amtTobeDeductedforAggHide=$myrow["Amount"];
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
                                                        if(trim($myrow["sector_business"])=="")
                                                                $showindsec=$myrow["industry"];
                                                        else
                                                                $showindsec=$myrow["sector_business"];

                                                                 
                                                              
                                                        ?>
                                                        <?php
                                                        if($searchallfield != ''){
                                        
                                        if(count($pe_checkbox) > 0 && $pe_checkbox[0]!='' &&  count($pe_checkbox_enable) > 0 && $pe_checkbox_enable[0]!=''){

                                                if( (in_array( $myrow["MAMAId"], $pe_checkbox )) ) {
                                                        $checked = '';
                                                        $rowClass = 'event_stop';

                                                } 
                                                elseif( (in_array( $myrow["MAMAId"], $pe_checkbox_enable )) ) {
                                                        $checked = 'checked';
                                                        $rowClass = '';

                                                } 
                                                elseif($_POST['full_uncheck_flag']==1){
                                                    $checked = '';
                                                    $rowClass = 'event_stop';
                                                }
                                                elseif($_POST['full_uncheck_flag']==''){
                                                    $rowClass = '';
                                                    $checked = 'checked';
                                                }

                                            }
                                            elseif(!empty( $pe_checkbox )  && $pe_checkbox[0]!=''){

                                                if( (in_array( $myrow["MAMAId"], $pe_checkbox )) ) {
                                                        $checked = '';
                                                        $rowClass = 'event_stop';

                                                }elseif($_POST['full_uncheck_flag']==1){
                                                    $checked = '';
                                                    $rowClass = 'event_stop';
                                                } else {
                                                        $checked = 'checked';
                                                        $rowClass = '';
                                                }

                                            }elseif( !empty( $pe_checkbox_enable ) && $pe_checkbox_enable[0]!=''){

                                                if( (in_array( $myrow["MAMAId"], $pe_checkbox_enable )) ) {
                                                        $checked = 'checked';
                                                        $rowClass = '';

                                                }elseif($_POST['full_uncheck_flag']==1){
                                                    $checked = '';
                                                    $rowClass = 'event_stop';
                                                } else {
                                                        $checked = '';
                                                        $rowClass = 'event_stop';
                                                }

                                            }elseif($_POST['full_uncheck_flag']==1){

                                                $checked = '';
                                                $rowClass = 'event_stop';
                                            }else{

                                                $checked = 'checked';
                                                $rowClass = '';
                                            }
                                    }
                                ?>
                                                        <tr class="details_link" valueId="<?php echo $myrow["MAMAId"];?>">
                                                        <?php

                                                        //Session Variable for storing Id. To be used in Previous / Next Buttons
                                                        //$_SESSION['resultId'][$icount++] = $myrow["MAMAId"];
                                                        ?><?php 
                                      if($searchallfield != ''){    
                                          ?>

                                    <td><input type="checkbox" data-deal-amount="<?php echo $myrow["Amount"]; ?>" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow[ 'PECompanyId' ]; ?>" class="pe_checkbox" <?php echo $checked; ?> value="<?php echo $myrow["MAMAId"];?>" /></td>
                                    <?php
                                        }
                                    ?>
                                                                <td style="width: 745px;"><?php echo $openBracket ; ?><?php echo $opensquareBracket; ?><a class="postlink" id="dealid<?php echo $myrow["MAMAId"];?>" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displaycomp;?>  </a> <?php echo $closesquareBracket; ?><?php echo $closeBracket ; ?></td>
                                                                <td style="width: 625px;"><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $sector; ?></a></td>
                                                                <td style="width: 625px;"><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displayAcquirer; ?></a></td>
                                                                <td style="width: 205px;"><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displaydate; ?></a></td>
                                                                <td style="width: 153px;"><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $hideamount; ?>&nbsp;</a></td>

                                                        </tr>
                                <!--</tbody>-->
                            <?php
                                                                $industryAdded = $myrow["industry"];
                            }
                        }
                            if( isset( $_POST[ 'pe_checkbox' ] ) && !empty( $_POST[ 'pe_checkbox' ] ) ) {
                                        $pecheckcount = count( $pe_checkbox );
                                        $totalInv = $totalInv - $pecheckcount;
                                        $_SESSION['totalcount'] = $totalInv;
                                    }
                                    //-------------------------------------junaid-------------------------------------
                                    if( isset( $_POST[ 'pe_hide_companies' ] ) && !empty( $_POST[ 'pe_hide_companies' ] ) ) {
                                        $hideCountCh = count( $pe_hide_companies );
                                        $totalInv = $totalInv + $hideCountCh;
                                        $_SESSION['totalcount'] = $totalInv;
                                    }
                                    //--------------------------------------------------------------------------
                                    if( isset( $_POST[ 'pe_amount' ] ) && !empty( $_POST[ 'pe_amount' ] ) ) {
                                        $totalAmount = $pe_amount;
                                    }
                                
                                    if( $peEnableFlag ) {
                                    if( !empty( $pe_company ) ) {
                               
                                        $cos_array1 = explode( ',', $pe_company );
                                        $total_cos = count(array_count_values($cos_array1));
                                    }elseif(!empty($_POST[ 'hide_pe_company'])){
                                        $cos_array1 = explode( ',', $_POST[ 'hide_pe_company'] );
                                        $total_cos = count(array_count_values($cos_array1));
                                    }
                                    else {

                                         $cos_array1  = '';
                                        $total_cos = 0;
                                    }
                                } else {
                                    $cos_array1 = $cos_array;
                                }
                        
                                    if($hidecount==1)
                                    {
                                            $totalAmount="--";
                                           /* $totalINRAmount="--";*/
                                }?>
                        </tbody>
                  </table>   
                </div>  
             <input type="hidden" name="pe_checkbox_disbale" id="pe_checkbox_disbale" value="<?php echo implode( ',', $pe_checkbox ); ?>">
        <input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
         <input type="hidden" name="pe_checkbox_amount" id="pe_checkbox_amount" value="">
        <input type="hidden" name="pe_checkbox_company" id="pe_checkbox_company" value="<?php echo implode( ',', $cos_array1 ); ?>">
<?php if($searchallfield != ''){?>    
          <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php if($_POST['real_total_inv_deal']!=''){ echo $_POST['real_total_inv_deal']; }else{ echo $totalInv; } ?>">
                <input type="hidden" name="real_total_inv_amount" id="real_total_inv_amount" value="<?php if($_POST['real_total_inv_amount']!=''){ echo $_POST['real_total_inv_amount']; }else{ echo $totalAmount; } ?>">
                 <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php if($_POST['real_total_inv_company']!=''){ echo $_POST['real_total_inv_company']; }else{ echo $acrossDealsCnt; } ?>">
                
                 <input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php if($_POST['total_inv_deal']!=''){ echo $_POST['total_inv_deal']; }else{  echo $totalInv; }?>">
                <input type="hidden" name="total_inv_amount" id="total_inv_amount" value="<?php if($_POST['total_inv_amount']!=''){ echo $_POST['total_inv_amount']; }else{  echo $totalAmount; }?>">
                <input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php if($_POST['total_inv_company']!=''){ echo $_POST['total_inv_company']; }else{  echo $acrossDealsCnt;}?>">
                  <input type="hidden" name="array_comma_company" id="array_comma_company" value="<?php echo $company_array_comma; ?>">
                  <input type="hidden" name="all_checkbox_search" id="all_checkbox_search" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
                <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST[ 'pe_hide_companies' ]; ?>">
                <?php }?>
                <!-- <div class="pageinationManual"> -->
             <div class="holder" style="float:none; text-align: center;">
             <div class="paginate-wrapper" style="display: inline-block;">
                 <?php
                    $totalpages=  ceil($company_cntall/$rec_limit);
                    $firstpage=1;
                    $lastpage=$totalpages;
                    $prevpage=(( $currentpage-1)>0)?($currentpage-1):1;
                    $nextpage=(($currentpage+1)<$totalpages)?($currentpage+1):$totalpages;
                 ?>
                 
                  <?php
                    $pages=array();
                    $pages[]=1;
                    $pages[]=$currentpage-2;
                    $pages[]=$currentpage-1;
                    $pages[]=$currentpage;
                    $pages[]=$currentpage+1;
                    $pages[]=$currentpage+2;
                    $pages[]=$totalpages;
                    $pages =  array_unique($pages);
                    sort($pages);
                 if($currentpage<2){
                 ?>
                 <a class="jp-previous jp-disabled" >&#8592; Previous</a>
                 <?php } else { ?>
                 <a class="jp-previous" >&#8592; Previous</a>
                 <?php } for($i=0;$i<count($pages);$i++){ 
                     if($pages[$i] > 0 && $pages[$i] <= $totalpages){
                ?>
                 <a class='<?php echo ($pages[$i]==$currentpage)? "jp-current":"jp-page" ?>'  ><?php echo $pages[$i]; ?></a>
                 <?php } 
                     }
                     if($currentpage<$totalpages){
                     ?>
                 <a class="jp-next">Next &#8594;</a>
                     <?php } else { ?>
                  <a class="jp-next jp-disabled">Next &#8594;</a>
                     <?php  } ?>
             </div>
             </div>

            
            <!-- </div> -->

                        <center>
            <div class="pagination-section"><input type="text" name = "paginaitoninput" id = "paginationinput" class = "paginationtextbox" placeholder = "PageNo" onkeyup = "paginationfun(this.value)">
             <button class = "jp-page1 button pagevalue" name="pagination"  id="pagination" type="submit" onclick = "validpagination()"> Go</button>
            </div>
            </center>

            <?php
                    }else{
                                            echo '<div style="margin-left:30px;margin-top:20px;"><h3>No Data Found</h3></div>';
                                        }
                } 
            ?>                       
            <?php
                
            $totalAmount=round($totalAmount, 0);
            $totalAmount=$totalAmount;
            $totalComp=$_POST['total_inv_company'];
                if($studentOption==1)
                {
                 ?>
                         <script type="text/javascript" >
                                $("#show-total-deal").html('<h2> Total No. of Deals <span class="total_deal"><?php if($_POST['total_inv_deal']!=''){ echo $_POST['total_inv_deal']; }else{  echo $totalInv; }?></span></h2>');
                                $("#show-total-amount").html('<h2> Announced Value US$ <span class="res_total"><?php
                                if($totalAmount >0)
                               {
                                   echo number_format(round($totalAmount));
                               }
                               else
                               {
                                   echo "--";
                               }?></span> M  across <span class="comp_total"><?php if($totalComp!='' && $searchallfield!=''){ echo $totalComp; }else{ echo $acrossDealsCnt; }?></span> deals;&nbsp;</h2>');
                            </script>
                            
                 
                <?php
                if($exportToExcel==1 )
                {
                ?>
                  <span style="float:right;margin-right: 20px;" class="one">
                  <input class ="export_new" type="button" id="expshowdealsbtn"  value="Export" name="showdeals">
                  </span>
                        <div class="title-links" id="exportbtn"></div>
                  <script type="text/javascript">
                        $('#exportbtn').html('<input class ="export_new" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                </script>
                <?php
                
                }
                $_SESSION['aggvalue']='<h2> Announced Value US$ <span class="res_total">'.$totalAmount.' </span>M  across <span class="comp_total"><?php if($totalComp){?>'. $totalComp.'<?php }else{?>'.$acrossDealsCnt.'<?php}?></span> deals;&nbsp</h2>';
        }
        else
        {
                    if($exportToExcel==1)
                    {
                    ?>
                             <script type="text/javascript" >
                                $("#show-total-deal").html('<h2> Total No. of Deals <span class="total_deal"> <?php if($_POST['total_inv_deal']!=''){ echo $_POST['total_inv_deal']; }else{  echo $totalInv; }?></span></h2>');
                                $("#show-total-amount").html('<h2> Announced Value US$ <span class="res_total"><?php 
                                if($totalAmount >0)
                               {
                                   echo number_format(round($totalAmount));
                               }
                               else
                               {
                                   echo "--";
                               }?></span> M  across <span class="comp_total"><?php if($totalComp!='' && $searchallfield!=''){ echo $totalComp; }else{ echo $acrossDealsCnt; }?></span> deals;&nbsp;</h2> ');
                            </script>
                           
                    <?php
                    $_SESSION['aggvalue']='<h2> Announced Value US$ <span class="res_total">'.$totalAmount.'</span> M  across <span class="comp_total"><?php if($totalComp){?>'. $totalComp.'<?php }else{?>'.$acrossDealsCnt.'<?php}?></span> deals;</h2>';
                    }
                    else
                    {
                    ?>
                            <script type="text/javascript" >
                                $("#show-total-deal").html('<h2> Total No. of Deals XXX</h2>');
                                $("#show-total-amount").html('<h2>Announced Value(US$ M) YYY  across ZZZ deals</h2>');
                            </script>
                            <div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
                    <?php
                    $_SESSION['aggvalue']="";
                    }
                            if(($totalInv>0) &&  ($exportToExcel==1))
                            {
                            ?>
                                    <span style="float:right;margin-right: 20px;" class="one">
                                    <input class ="export_new" type="button" id="expshowdealsbtn"  value="Export" name="showdeals">
                                    </span>
                                    <script type="text/javascript">
                    $('#exportbtn').html('<input class ="export_new" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                                    </script>
                                    
                            <?php
                            }
                            elseif(($totalInv>0) && ($exportToExcel==0))
                            {
                                                                
                            ?>
                                <div>
                                    <span>
                                    <b>Note:</b> Only paid subscribers will be able to export data on to Excel.
                                    <span style="float:right;margin-right: 20px;" class="one">
                                    <a target="_blank" href="../Sample_merger_acq_data.xls"><u>Click Here</u> </a> for a sample spreadsheet containing M&A deals
                                    </span>
                                    <script type="text/javascript">
                        $('#exportbtn').html('<a class="export" id="expsampledeals"   href="../Sample_merger_acq_data.xls">Export Sample</a>');
                                    </script>
                                    </span>
                                </div>
                                    
              
                    <?php
                            }
              }
                ?>
    </div>
<?php if($notable==false) { ?>
<div class="overview-cnt mt-trend-tab">
        
                        <div class="showhide-link" id="trendnav" style="z-index: 100000"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? '' : ''; ?>" rel="#slidingTable" id='ldtrend'><i></i>Trend View</a></div>
                            <div id="slidingTable" style="display: none;overflow:hidden;">
                       <?php
                       include_once("trendviewma.php");
                       ?>   
                       <table width="100%">
                            <?php
                                if($type!=1)
                                {
                                 ?>
                                <tr>
                                <td width="50%" class="profile-view-left">
                                 <div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
                                </td>
                                <td class="profile-view-rigth" width="50%" >
                                  <div id="visualization3" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>  
                                </td>
                                </tr> 

                                <tr>
                                <td width="50%" class="profile-view-left" id="chartbar">
                                        <div id="visualization1" style="max-width: 100%; height: 750px;overflow-x: auto;overflow-y: hidden;"></div>    
                                </td>
                                <td  id="chartbar" class="profile-view-rigth" width="50%" >
                                        <div id="visualization" style="max-width: 100%; height: 700px;overflow-x: auto;overflow-y: hidden;"></div> 
                                </td>
                                </tr>
                                <?php
                                }
                                else
                                {
                                ?>
                                <tr>
                                        <td colspan="2" width="100%">
                                <div id="visualization2" style="max-width: 100%; height: 600px;overflow-x: auto;overflow-y: hidden;"></div>   
                                </td>
                                </tr> 
                                <?php
                                }
                            ?>
                            
                            <tr>
                             <td class="profile-view-left" colspan="2">
                                 <div class="showhide-link link-expand-table" id="navTable">
                                    <a href="#" class="show_hide" rel="#slidingDataTable">View Table</a>
                                 </div><br>
                                 <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;margin-top: 0px">
                                    <div class="restable">
                                        <table class="testTable1" cellpadding="0" cellspacing="0" id="restable">
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </div>
                                 </div>
                             </td>
                            </tr>
                       </table>  
                    </div>
                    </div>
<?php } ?>
</td>
<input type="hidden" name="period_flag" id="period_flag" value="<?php echo $period_flag; ?>" />
</tr>
</table>
 
</div>

</form>
            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $totalInv; ?>">
            <form name="pelisting" id="pelisting"  method="post" action="exportmeracq.php">
                <?php if($_POST) { 

                	if($_GET['search']!=''){
                        $month1=01; 
                        $year1 = 2004;
                        $month2= date('n');
                        $year2 = date('Y');

                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-31";
                    }

                	?>
                       
                        <input type="hidden" name="txtsearchon" value="4" >
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="txthideindustry" value=<?php echo $industry_hide; ?> >
            <input type="hidden" name="txthideindustryvalue" value=<?php echo $industryvalue; ?> >
            <input type="hidden" name="txthidetargetcomptype" value=<?php echo $target_comptype; ?> >
            <input type="hidden" name="txthideacquirercomptype" value=<?php echo $acquirer_comptype; ?> >
                        <input type="hidden" name="txthidedealtype" value=<?php echo implode(",", $dealtype); ?> >
            <input type="hidden" name="txthidedealtypevalue" value=<?php echo $dealtypevalue; ?> >
            <input type="hidden" name="txthideSPV" value=<?php echo $targetProjectTypeId; ?> >
              <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode( ',', $pe_checkbox ); ?>">
              <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
               <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
               
             <input type="hidden" name="txthiderange" value=<?php echo $rangeText; ?> >
            
                        <?php if($startRangeValue==0) { ?>
                        <input type="hidden" name="txthiderangeStartValue" value="0.01" >
                        <?php } else { ?>
            <input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?> >
                        <?php } ?>
                        
            <input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValue; ?> >
                        
                        <input type="hidden" name="txthidevaluation" value="<?php echo $valuationsql; ?> ">
                          
            <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
            <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
            <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

            <input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
                        <input type="hidden" name="txthidecompanyId" value=<?php echo $targetCompanyId; ?> >
                        <input type="hidden" name="txthidesector" value="<?php echo $sectorsearchhidden; ?>" >
            <input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
            <input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
            <input type="hidden" name="txthideacquirer" value=<?php echo $aquirersearchhidden; ?> >
                        <input type="hidden" name="txthideacquirerId" value=<?php echo $acquirerId; ?> >
            <input type="hidden" name="txttargetcountry" value=<?php echo $targetcountry_hide; ?>>
            <input type="hidden" name="txtacquirercountry" value=<?php echo $acquirercountry_hide; ?>>
            <input type="hidden" name="txthidesearchallfield" value="<?php echo $searchallfieldhidden; ?>" >
                        
                 <?php } else {

                 	if($_GET['search']!=''){
                        $month1=01; 
                        $year1 = 2004;
                        $month2= date('n');
                        $year2 = date('Y');

                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-31";
                    }

                  ?> 
                        
                        <input type="hidden" name="txtsearchon" value="4" >
                       
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="txthideindustry" value="">
            <input type="hidden" name="txthideindustryvalue" value="--">
            <input type="hidden" name="txthidetargetcomptype" value="--">
            <input type="hidden" name="txthideacquirercomptype" value="--" >
            <input type="hidden" name="txthidedealtype" value="--" >
            <input type="hidden" name="txthidedealtypevalue" value="" >
            <input type="hidden" name="txthideSPV" value="" >

            <input type="hidden" name="txthiderange" value="--" >
            <input type="hidden" name="txthiderangeStartValue" value="--" >
            <input type="hidden" name="txthiderangeEndValue" value="--" >
            <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
            <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
            <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

            <input type="hidden" name="txthidecompany" value="--" >
            <input type="hidden" name="txthideadvisor_legal" value="--" >
            <input type="hidden" name="txthideadvisor_trans" value="--" >
            <input type="hidden" name="txthideacquirer" value="--" >
            <input type="hidden" name="txttargetcountry" value="--">
            <input type="hidden" name="txtacquirercountry" value="--">
            <input type="hidden" name="txthidesearchallfield" value="--">
                        
                 <?php } ?> 
                
</form>
            <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
            <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
            <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
            <script src="<?php echo $refUrl; ?>js/listviewfunctions.js"></script>
             <script type="text/javascript">
                orderby='<?php echo $orderby; ?>';
                 ordertype='<?php echo $ordertype; ?>';
                $(".jp-next").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    pageno=$("#next").val();
                    $("#paginationinput").val('');
                    loadhtml(pageno,orderby,ordertype);}
                    return  false;
                });
                $(".jp-page").live("click",function(){
                    pageno=$(this).text();
                    $("#paginationinput").val('');
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
                $(".jp-page1").live("click",function(){
                    pageno=$(this).val();
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
                $(".jp-previous").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    pageno=$("#prev").val();
                    $("#paginationinput").val('');
                    loadhtml(pageno,orderby,ordertype);
                    }
                    return  false;
                });
        $(".header").live("click",function(){
                    orderby=$(this).attr('id');
                    
                    if($(this).hasClass("asc"))
                        ordertype="desc";
                    else
                        ordertype="asc";
                    loadhtml(1,orderby,ordertype);
                    return  false;
                });     

                $( document ).ready(function() {

                    var x = localStorage.getItem("pageno");
                    //alert(x);
                    if(x != 'null' && x != null)
                    {
                    loadhtml(x,orderby,ordertype)
                    }
                });

               function loadhtml(pageno,orderby,ordertype)
               {
                localStorage.setItem("pageno", pageno);
                $('#paginationinput').val(pageno)


               var peuncheckVal = $( '#pe_checkbox_disbale' ).val();
                    var full_check_flag =  $( '#all_checkbox_search' ).val();
                    var pecheckedVal = $( '#pe_checkbox_enable' ).val();
                jQuery('#preloading').fadeIn(1000);   
                $.ajax({
                type : 'POST',
                url  : 'ajaxListview_ma.php',
                data: {

                        sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                        totalrecords : '<?php echo addslashes($company_cntall); ?>',
                        page: pageno,
                        vcflagvalue:'<?php echo $vcflagValue; ?>',
                        orderby:orderby,
                        ordertype:ordertype,
                        searchField: '<?php echo $searchallfield; ?>',
                        uncheckRows: peuncheckVal,
                        checkedRow:pecheckedVal,
                        full_uncheck_flag :  full_check_flag
                },
                success : function(data){
                        $(".view-table-list").html(data);
                        $(".jp-current").text(pageno);
                       var prev=parseInt(pageno)-1
                        if(prev>0)
                        $("#prev").val(pageno-1);
                        else
                        {
                        $("#prev").val(1);
//                        $(".jp-previous").addClass('.jp-disabled').removeClass('.jp-previous');
                        }
                        $("#current").val(pageno);
                       var  next=parseInt(pageno)+1;
                        if(next < <?php echo $totalpages ?> )
                         $("#next").val(next);
                        else
                        {
                        $("#next").val(<?php echo $totalpages ?>);
//                        $(".jp-next").addClass('.jp-disabled').removeClass('.jp-next');
                        }
                        drawNav(<?php echo $totalpages ?>,parseInt(pageno))
                        jQuery('#preloading').fadeOut(500); 
                       
                        return  false;
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                        jQuery('#preloading').fadeOut(500);
                        alert('There was an error');
                }
            });
               }
             </script>
            <script type="text/javascript">
                
    /* $(".export").click(function(){
            $("#pelisting").submit();
        });*/
    
       $('#expshowdeals').click(function(){
           
        /*jQuery('#preloading').fadeIn();   
        initExport();
         hopscotch.showStep(15);
        return false;*/
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });

    $('#expshowdealsbtn').click(function(){ 
        
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });
            $( '#month1' ).on( 'change', function() {
                $( '#period_flag' ).val(2);
            });
            $( '#year1' ).on( 'change', function() {
                $( '#period_flag' ).val(2);
            });
            $( '#month2' ).on( 'change', function() {
                $( '#period_flag' ).val(2);
            });
    function initExport(){ 
        
            $.ajax({
                url: 'ajxCheckDownload.php',
                dataType: 'json',
                success: function(data){
                    var downloaded = data['recDownloaded'];
                    var exportLimit = data.exportLimit;
                    var currentRec = <?php echo $totalInv; ?>;
                    
                    //alert(currentRec + downloaded);
                    var remLimit = exportLimit-downloaded;

                    if (currentRec < remLimit){
                        //hrefval= 'exportreinvdeals.php';
                        //$("#pelisting").attr("action", hrefval);
                        $("#pelisting").submit();
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
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
                
            $(document).on('click', 'tr .details_link', function(){ 
                
                idval=$(this).attr("valueId");
                $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>ma/madealdetails.php?value="+idval).trigger("click");
            });

            </script>
            
<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>          
</body>
</html>
<script>
  $(function() {
 
  });
    var pehideFlag = '';
                /*$( '.pe_checkbox' ).on( 'ifChanged', function(event) {*/
                 $(document).on( 'ifChanged','.pe_checkbox', function(event) {
                    
                    var amountChnage = true;
                    var peuncheckCompdId = $( event.target ).val();
                    
                    var peuncheckAmount = $(event.target).data('deal-amount');
                    var peuncheckCompany = $( event.target ).data( 'company-id' );
                    pehideFlag = $(event.target).data('hide-flag');
                    var total_invdeal = $("#real_total_inv_deal").val();
                    var total_invcompany = $("#real_total_inv_company").val();
                    
                    if( peuncheckAmount == '--' || pehideFlag == 1 || peuncheckAmount == 0.00 ) {
                        amountChnage = false;
                    } else {
                        peuncheckAmount = parseFloat( $(event.target).data('deal-amount') );
                    }
                    var cur_val = $("#pe_checkbox_disbale").val();
                    var cur_val1 = $("#hide_company_array").val();
                    var cur_va2 = $("#pe_checkbox_enable").val();

                    var lastElement = $(event.target).parents('#myTable tbody .details_link').is(':last-child');
                    
                    if( $( event.target ).prop('checked') ) {

                        $(event.target).parents('.details_link').removeClass('event_stop');
                       if( cur_va2 != '' ) {
                            $('#pe_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );
                            $('#export_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );

                        } else {
                            $('#pe_checkbox_enable').val( peuncheckCompdId );
                            $('#export_checkbox_enable').val( peuncheckCompdId );

                        }
                        var strArray = cur_val.split(',');
                        for( var i = 0; i < strArray.length; i++ ) {
                            if ( strArray[i] === peuncheckCompdId ) {
                                strArray.splice(i, 1);
                            }
                        }
                        $('#pe_checkbox_disbale').val( strArray );
                        $('#txthidepe').val( strArray );

                        var strArray1 = cur_val1.split(',');
                        for( var i = 0; i < strArray1.length; i++ ) {
                            if ( strArray1[i] === peuncheckCompdId ) {
                                strArray1.splice(i, 1);
                            }
                        }
                        if( pehideFlag == 1 ) {

                            $( '#hide_company_array' ).val( strArray1 );
                        }

                        updateCountandAmount(  peuncheckAmount, 'add', amountChnage, pehideFlag, total_invdeal);
                        updateCompanyCount( peuncheckCompany, 'add',lastElement, pehideFlag,total_invcompany );
                    }else {
                    
                        $(event.target).parents('.details_link').addClass('event_stop');

                        var strArray2 = cur_va2.split(',');
                        for( var i = 0; i < strArray2.length; i++ ) {
                            if ( strArray2[i] === peuncheckCompdId ) {
                                strArray2.splice(i, 1);
                            }
                        }
                        $('#pe_checkbox_enable').val( strArray2 );
                        $('#export_checkbox_enable').val( strArray2 );

                        if( cur_val != '' ){
                            $('#pe_checkbox_disbale').val( cur_val + "," + peuncheckCompdId );
                            $('#txthidepe').val( cur_val + "," + peuncheckCompdId );
                        }else{
                            $('#pe_checkbox_disbale').val( peuncheckCompdId );
                            $('#txthidepe').val( peuncheckCompdId );
                        }
                        if( pehideFlag == 1 ) {

                            if( cur_val1 != '' ) {
                                $('#hide_company_array').val( cur_val1 + "," + peuncheckCompdId );
                            } else {
                                $('#hide_company_array').val( peuncheckCompdId );
                            }

                        }
                        updateCountandAmount(  peuncheckAmount, 'remove', amountChnage, pehideFlag,total_invdeal);
                        updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag,total_invcompany );
                    }
                
                });
            
                //$( '.all_checkbox' ).on( 'ifChanged', function(event) {
                $(document).on( 'ifChanged','.all_checkbox', function(event) {
                    if( $( event.target ).prop('checked') ) {
               
                      $( '#pe_checkbox_company' ).val($("#array_comma_company").val());

                        $( '#show-total-amount span.res_total' ).text( $("#real_total_inv_amount").val() );
                        $( '#show-total-amount h2 span.comp_total' ).text($("#real_total_inv_company").val() );
                        $( '#pe_checkbox_disbale' ).val('');
                        $( '#show-total-deal h2 span.total_deal' ).text($("#real_total_inv_deal").val());
                        $( '#total_inv_amount' ).val($("#real_total_inv_amount").val());
                        $( '#total_inv_company' ).val($("#real_total_inv_company").val());
                        $( '#txthidepe' ).val('');
                        $( '#pe_checkbox_enable' ).val('');
                        $( '#export_checkbox_enable' ).val('');
                        $( '#all_checkbox_search' ).val('');
                        $( '#export_full_uncheck_flag' ).val('');
                        $( '#hide_company_array' ).val('');
                        $( '#expshowdeals').show();
                        $( '#expshowdealsbtn').show();

                        $('.pe_checkbox').each(function(){ //iterate all listed checkbox items
                            $(this).prop("checked",true);
                            $(this).parents('.details_link').removeClass('event_stop');
                            $(this).parents('.icheckbox_flat-red').addClass('checked');
                        });
                    
                    }else{
                     
                        $(event.target).parents('.details_link').addClass('event_stop');
                        $( '#pe_checkbox_company' ).val('');
                        $( '#pe_checkbox_enable' ).val('');
                        $( '#hide_company_array' ).val('');
                        $( '#export_checkbox_enable' ).val('');
                        $( '#pe_checkbox_disbale').val('');
                        $( '#show-total-amount h2 span.res_total' ).text( 0 );
                        $( '#show-total-amount h2 span.comp_total' ).text(0 );
                        $( '#show-total-deal h2 span.total_deal' ).text( 0 );
                        $( '#total_inv_amount' ).val('0');
                        $( '#total_inv_company' ).val('0');
                        $( '#all_checkbox_search' ).val('1');
                        $( '#export_full_uncheck_flag' ).val('1');
                        $( '#expshowdeals').hide();
                        $( '#expshowdealsbtn').hide();

                        $('.pe_checkbox').each(function(){ //iterate all listed checkbox items

                           $(this).parents('.details_link').addClass('event_stop');
                           $(this).prop('checked',false);
                        });
                        $('.icheckbox_flat-red').removeClass('checked');
                    }
                });
                 $('#expshowdeals').click(function(){ 
                
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
                
            });
            
            $('#expshowdealsbt').click(function(){ 
                /*jQuery('#preloading').fadeIn();   
                initExport();
                return false;*/
                
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });


            function updateCountandAmount( elementAmount, type, amountFlag, pehideFlag, total_invdeal ) {

                var totalFound = parseFloat( $( '#show-total-deal span.total_deal' ).text() );
                var labelAmount = $( '#show-total-amount h2 span.res_total' ).text();
                var labelDeals = parseInt($( '#show-total-amount h2 span.comp_total' ).text());

                var amountChange = true;
                //alert(elementAmount);
                if( labelAmount == '--' || elementAmount == 0.00) {
                    amountChange = false;  
                } else {
                    var totalResAmount = parseFloat( labelAmount.replace(',','').replace(' ','') );
                }
                if( type == 'add' ) {
                    var currAmount = totalResAmount + elementAmount;
                   if(pehideFlag!=1){
                        var currTotal = totalFound + 1;
                    }else{
                        var currTotal = totalFound;
                    }
                } else {
                    var currAmount = totalResAmount - elementAmount;
                    if(pehideFlag!=1){
                        var currTotal = totalFound - 1;
                    }else{
                        var currTotal = totalFound;
                    }
                }
                if( currAmount < 0 || currTotal == 0 ) {
                    currAmount = 0;
                    $( '#expshowdeals').hide(); //junaid
                    $( '#expshowdealsbtn').hide();
                }else{
                    $( '#expshowdeals').show(); //junaid
                    $( '#expshowdealsbtn').show();
                }
                
                if( amountFlag && amountChange ) {
                    
                    if( type == 'add' ) {
                        var currDealsTotal = labelDeals + 1;
                    } else {
                        var currDealsTotal = labelDeals - 1;
                    }
                    if(currDealsTotal == 0 || currDealsTotal < 0){
                        currAmount = 0;
                        currDealsTotal = 0;
                    }
                    $( '#show-total-amount h2 span.res_total' ).text( currAmount.toFixed(2) );
                    $( '#show-total-amount h2 span.res_total' ).text($( '#show-total-amount h2 span.res_total' ).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $( '#pe_checkbox_amount' ).val( currAmount.toFixed(2) );
                    $( '#total_inv_amount').val(currAmount.toFixed(2));
                    $( '#show-total-amount h2 span.comp_total' ).text( currDealsTotal );
                    $( '#total_inv_company').val(currDealsTotal);
                }
                
                 //------------------------------junaid--------------------------------
                
               if(currTotal >= total_invdeal && $('#hide_company_array').val()==''){
                    $('#export_checkbox_enable').val('');
                    $('#all_checkbox').prop('checked',true);
                    $('#all_checkbox').parents('.icheckbox_flat-red').addClass('checked');
                    //$( '#all_checkbox_search' ).val('1');
                }else{
                    $('#all_checkbox').prop('checked',false);
                    $('#all_checkbox').parents('.icheckbox_flat-red').removeClass('checked');
                    
                }
                //-------------------------------------------------------
                if( pehideFlag == 0 ) {
                    $( '#show-total-deal h2 span.total_deal' ).text( currTotal );    
                    $( '#total_inv_deal').val(currTotal); //junaid
                }
            }

        
            function updateCompanyCount( elementCompany, type, lastElement, pehideFlag,total_invcompany ) {
               
                var counts = {};
                var removedcompanyData = '';
                var companyData = $( '#pe_checkbox_company' ).val();
                
                if( type == 'remove' ) {
                    if( pehideFlag == 0 ) {

                        removedcompanyData = companyData.replace( elementCompany, '' );
                        removedcompanyData = removedcompanyData.replace(/(^,)|(,$)/g, "");
                        $('#pe_checkbox_company').val( removedcompanyData );   
                    }                    
                } else {
                    if( pehideFlag == 0 ) {
                        if( companyData != '' ) {
                            $('#pe_checkbox_company').val( companyData + "," + elementCompany );
                        } else {
                            $('#pe_checkbox_company').val( elementCompany );
                        }
                    }
                }
                var newCompanyData = $( '#pe_checkbox_company' ).val();
                var arr = newCompanyData.split(',');
                jQuery.each(arr, function(key,value) {
                    if( value != '' ) {
                        if (!counts.hasOwnProperty(value)) {
                            counts[value] = 0;
                        } else {
                            counts[value]++;
                        }    
                    } 
                });
                
                //$( '#show-total-amount h2 span.comp_total' ).text( Object.keys(counts).length ); 
                //$( '#total_inv_company').val(Object.keys(counts).length); //junaid
            }


  </script>
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

if($type==1){?>
   
    <script language="javascript">
    $(document).ready(function(){
        $("#ldtrend").click(function () {
            if($(".show_hide").attr('class')!='show_hide'){
                var htmlinner = $(".profile-view-title").html();
                $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                //Execute SQL
                $.ajax({
                    type : 'POST',
                    url  : 'ajxQuery.php',
                    dataType : 'json',
                    data: {
                        sql : "<?php echo addslashes($companysql); ?>",
                    },
                    success : function(data){
                        drawVisualization(data);
                        $(".profile-view-title").html(htmlinner);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('There was an errors' + textStatus + errorThrown);
                    }
                });
            }
        });
    });
    </script>

    
    <script type="text/javascript">
      function drawVisualization(dealdata) {
        
        var data = new google.visualization.DataTable();
        data.addColumn('string','Year');
        data.addColumn('number', 'No of Deals');
        data.addColumn('number', 'Amount($m)');
        data.addRows(dealdata.length);
        for (var i=0; i< dealdata.length ;i++){
            for(var j=0; j< dealdata[i].length ;j++){
                if (j!=0)
                    data.setValue(i, j,Math.round(dealdata[i][j]-0));
                else
                    data.setValue(i, j,dealdata[i][j]);
            }           
        }
                
        // Create and draw the visualization.
        var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
        
        divwidth  =  document.getElementById("visualization2").offsetWidth;
        divheight =  document.getElementById("visualization2").offsetHight;
        
       function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=0&y='+topping;
             <?php if($drilldownflag==1){ ?>             
                //window.location.href = 'index.php?'+query_string;          
             <?php } ?>
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
             
             //Fill table
             var pintblcnt = '';
             var tblCont = '';
                         
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
             //pintblcnt = pintblcnt + '</thead>';
             //pintblcnt = pintblcnt + '<tbody>';
             
             //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';
             for (var i=0; i< dealdata.length ;i++){
                tblCont = tblCont + '<tr>';
                for(var j=0; j< dealdata[i].length ;j++){
                    if (j==0){
                        pintblcnt = pintblcnt + '<tr><th style="text-align:center">'+ dealdata[i][j] + '</th><tr>';
                    }
                    tblCont = tblCont + '<td style="text-align:center">'+ dealdata[i][j] + '</td>';
                }
                tblCont = tblCont + '</tr>';
                                
             }
             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
             
             //updateTables();
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
    else if($type==2) {  //  print_r($deal);   ?>
    
    <script language="javascript">
    $(document).ready(function(){
        $("#ldtrend").click(function () {
            if($(".show_hide").attr('class')!='show_hide'){
                var htmlinner = $(".profile-view-title").html();
                $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                //Execute SQL
                $.ajax({
                    type : 'POST',
                    url  : 'ajxQuery.php',
                    dataType : 'json',
                    data: {
                        sql : '<?php echo addslashes($companysql); ?>',
                    },
                    success : function(data){
                        drawVisualization(data);
                        $(".profile-view-title").html(htmlinner);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('There was an error');
                    }
                });
            }
        });
    });
    </script>
    
    
     <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }    
     
        function drawVisualization(dealdata) {  
        
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);           
            }
            
            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);
                    
            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }
            
            //Data by Year and industry
            var datayear = [];
            
            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }
    
            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var arrval = [];
                arrval.push(Years[j]);
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]);                   
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);
            
            // Create and populate the data table.       
            var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
            divwidth=  document.getElementById("visualization1").offsetWidth;
            divheight=  document.getElementById("visualization1").offsetHight;
            
            function selectHandler() {
                var selectedItem = chart1.getSelection()[0];
                if (selectedItem) {
                    var topping = data1.getValue(selectedItem.row, 0);
                    var industry = data1.getColumnLabel(selectedItem.column).toString();
                    //alert('The user selected ' + topping +industry);
           
                    var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
                    <?php if($drilldownflag==1){ ?>
                     //window.location.href = 'index.php?'+query_string;
                    <?php } ?>
                  }
            }
    
            google.visualization.events.addListener(chart1, 'select', selectHandler);
            chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                 /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true,
              });
              
              
            //Graph 2
            var data = new google.visualization.DataTable();
            data.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data.addColumn('number',dealdata[i][0]);            
            }
            
            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);
                    
            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }
            
            //Data by Year and industry
            var datayear = [];
            
            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }
    
            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var arrval = [];
                arrval.push(Years[j]);
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]);                   
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            var data = google.visualization.arrayToDataTable(dataArray);
            //var data = new google.visualization.DataTable();
            
            var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
         
             function selectHandler2() {
              var selectedItem = chart2.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var industry = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);
               
                var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
                <?php if($drilldownflag==1){ ?>
                 //window.location.href = 'index.php?'+query_string;
                <?php } ?>
              }
            }
             google.visualization.events.addListener(chart2, 'select', selectHandler2);
              chart2.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }
              );   
              
              
            //Graph 3           
            var data3 = new google.visualization.DataTable();
            data3.addColumn('string','Industry');
            data3.addColumn('number', 'No of Deals');
            
            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }
            
            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);          
            }
            
            
            
            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"No of Deals"/*,
              colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
            
            
            //Graph 4
        
            var data4 = new google.visualization.DataTable();
            data4.addColumn('string','Industry');
            data4.addColumn('number', 'Amount');
            
            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(Math.round(dealdata[i][3]-0));
                    dataArray.push(temArray);
                }
            }
            
            //console.log(dataArray);
            //console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
    
            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount"/*,
             colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
            
            
            //Fill table
            
            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            
                    
            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }
            
            
            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');
                            
                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');
                            
                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }
            
            //console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
             
                        //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">INDUSTRY</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';      
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                 if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';     
             }
             tblCont = tblCont + '</tr>';
              
             
             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';
             
             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];
            
            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    //flag =1;
                }
                tblCont = tblCont + '<tr>';
                //console.log(dataArray[arrhead[i]]);
            }
            
             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
        }
        
        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }
    </script>
    
       
    <? 
     }
    else if($type == 4 ){
   ?>
    <script language="javascript">
        $(document).ready(function(){
            $("#ldtrend").click(function () {
                if($(".show_hide").attr('class')!='show_hide'){
                    var htmlinner = $(".profile-view-title").html();
                    $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

                    //Execute SQL
                    $.ajax({
                        type : 'POST',
                        url  : 'ajxQuery.php',
                        dataType : 'json',
                        data: {
                            sql : '<?php echo addslashes($compRangeSql); ?>',
                            typ : '4',
                            rng : '<?php echo implode('#',$range);?>',
                        },
                        success : function(data){
                            drawVisualization(data);
                            $(".profile-view-title").html(htmlinner);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('There was an error');
                        }
                    });
                }
            });
        });
    </script>
   <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }   
        
        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }
        
        function drawVisualization(dealdata) {
            
        //alert(dealdata.length);
                        
        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);           
            }
            
            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);
                    
            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }
            
            //Data by Year and industry
            var datayear = [];
            
            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }
    
            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);
                
                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]]; 
                }*/
                
                for (var i=1;i<arrhead.length;i++){                 
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);                 
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);  
            
            var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
              var selectedItem = chart6.getSelection()[0];
              if (selectedItem) {
                var topping = data1.getValue(selectedItem.row, 0);
                var range = data1.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);
               
               var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
                 <?php if($drilldownflag==1){ ?>           //  window.location.href = 'index.php?'+query_string;        
                                     <?php } ?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }
    
              );  
              
              
              
            //Graph 2
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);           
            }
            
            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);
                    
            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }
            
            //Data by Year and industry
            var datayear = [];
            
            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }
    
            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);
                
                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]]; 
                }*/
                
                for (var i=1;i<arrhead.length;i++){                 
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);                 
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            var data = google.visualization.arrayToDataTable(dataArray);  
            
            var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
                         function selectHandler2() {
              var selectedItem = chart7.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var range = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);
               
               var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
                 <?php if($drilldownflag==1){ ?>            // window.location.href = 'index.php?'+query_string;           
                                  <?php } ?>
              }
                          }
                          
             google.visualization.events.addListener(chart7, 'select', selectHandler2);
              chart7.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }
              );
            
            //Graph 3
             var data3 = new google.visualization.DataTable();
              data3.addColumn('string','Stage');
                data3.addColumn('number', 'No of Deals');
            
            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }
            
            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);          
            }
            
            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization2')).
                  draw(data3, {title:"No of Deals"/*,
                  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
            
            
            
            //Graph 4
            var data4 = new google.visualization.DataTable();
            data4.addColumn('string','Stage');
            data4.addColumn('number', 'Amount');
            
            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(Math.round(dealdata[i][3]-0));
                    dataArray.push(temArray);
                }
            }
            
            //console.log(dataArray);
            //console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
            
            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization3')).
                  draw(data4, {title:"Amount"/*,
                  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
            
            
            
            //Fill table
            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            
                    
            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }
            
            
            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');
                            
                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');
                            
                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }
            
            //console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
             
                        //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">RANGE</th>';
             for (var i=0; i< Years.length ;i++){
                if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';      
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';     
             }
             tblCont = tblCont + '</tr>';
              
             
             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';
             
             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];
            
            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    //flag =1;
                }
                
                //console.log(dataArray[arrhead[i]]);
            }
            
             
             //tblCont = tblCont + '</tbody>';
             pintblcnt = pintblcnt + '</table>';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
    
        }
    </script>
       
    <?php }
    if($_GET['type']!="")
    { ?>
        <script language="javascript">
        $(document).ready(function(){
                    setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
                    },1000);

                });
        </script>
    <?php }
 mysql_close();
    ?>
 <script type="text/javascript" >
     
     
      var containerWidth = $('#container').width();  
       var refineWidth = $('#panel').width();                                                                                
       var searchkeyWidth = $('.result-rt-cnt').width();
       var searchTitleWidth = $('.result-title').width();

       var filtersHeight = $('.filter-key-result').height();
       var tabHeight = $('.list-tab').height();
       var alertHeight = $('.alert-note').height();
             
             
            // if (window.innerWidth > 1700)
            // {
            //     var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 10;
            //     $('.result-select').css({"max-width":1190});
            // }
            // else if (window.innerWidth > 1024 )
            // {
            //     var searchTitleHeight = filtersHeight + tabHeight + alertHeight-30;
            //     $('.result-select').css({"max-width":530}); 
            //  }
            // else
            // {
            //     var searchTitleHeight = filtersHeight + tabHeight + alertHeight;
            //     $('.result-select').css({"max-width":390});
                  
            // }
            if (window.innerWidth > 1700)
                {
                    var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 10;
                    $('.result-select').css({"max-width":"97%"});
                }else if (window.innerWidth > 1280)
                {
                    var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 10;
                    $('.result-select').css({"max-width":"97%"});
                }
                else if (window.innerWidth > 1024 )
                {
                    var searchTitleHeight = filtersHeight + tabHeight + alertHeight-30;
                    $('.result-select').css({"max-width":"97%"});
                }
                else
                {
                    var searchTitleHeight = filtersHeight + tabHeight + alertHeight;
                    $('.result-select').css({"max-width":"97%"});
                }
            
            
            //$('.result-cnt').width(containerWidth-refineWidth+188);
            var resultcntHeight = $('.result-cnt').height()-1;
            
            //$('.view-table').css({"margin-top":resultcntHeight});
             $('.expand-table').css({"margin-top":0});
            
            //$('.view-table').css({"margin-top":window.innerHeight-826});
             
            $('.btn-slide').click(function(){ 
                
                $('.result-select').css('width', 'auto');
                $('.title-links').css('padding', '3px');
                var containerWidth = $('#container').width();  
                var refineWidth = $('#panel').width();      
                var searchkeyWidth = $('.result-rt-cnt').width();
                var searchTitleWidth = $('.result-title').width();
                var searchTitleHeight = $('.result-cnt').height(); 
              
                //$('.result-cnt').width(containerWidth-refineWidth-40)
               // $('.result-select').width(searchTitleWidth-searchkeyWidth-250);
               if ($('.left-td-bg').width() < 264) {
                    //$('.result-cnt').width(containerWidth-refineWidth-40); 

                    var searchTitleHeight = $('.result-cnt').height(); 
                    //$('.view-table').css({"margin-top":searchTitleHeight});
                    $('.expand-table').css({"margin-top":0});
                    if (window.innerWidth > 1700)
                {
                    $('.result-select').css({"max-width":"97%"});
                }else if (window.innerWidth > 1280)
                {
                    $('.result-select').css({"max-width":"97%"});
                }
                else if (window.innerWidth > 1024 )
                {
                    $('.result-select').css({"max-width":"97%"});
                }
                else
                {
                    $('.result-select').css({"max-width":"97%"});
                }
             
                } else {
                    //$('.result-cnt').width(containerWidth-refineWidth+188); 
                    //$('.result-select').width(searchTitleWidth-searchkeyWidth);

                    var searchTitleHeight = $('.result-cnt').height();  
                    //$('.view-table').css({"margin-top":searchTitleHeight});
                    $('.expand-table').css({"margin-top":0});
                    if (window.innerWidth > 1700)
                {
                    $('.result-select').css({"max-width":"97%"});
                }else if (window.innerWidth > 1280)
                {
                    $('.result-select').css({"max-width":"97%"});
                }
                else if (window.innerWidth > 1024 )
                {
                    $('.result-select').css({"max-width":"97%"});
                }
                else
                {
                    $('.result-select').css({"max-width":"97%"});
                }
             
                }
            });      
             
            
            $(window).resize(function() {        
        
                var containerWidth = $('#container').width();   
                var refineWidth = $('#panel').width(); 
                var searchkeyWidth = $('.result-rt-cnt').width();
                var searchTitleWidth = $('.result-title').width();
                var searchTitleHeight = $('.result-cnt').height(); 
                
                //$('.view-table').css({"margin-top":searchTitleHeight});
                $('.expand-table').css({"margin-top":0});
                //$('.result-select').width(searchTitleWidth-searchkeyWidth);
                
                //  if (window.innerWidth > 1700)
                // {
                //     $('.result-select').css({"max-width":1190});
                // }
                // else if (window.innerWidth > 1024 )
                // {
                //     $('.result-select').css({"max-width":530});
                //  }
                // else
                // {
                //     $('.result-select').css({"max-width":390});
                // }
                // if ($('.left-td-bg').width() < 264) {
                //    // $('.result-cnt').width(containerWidth-refineWidth+188);  
                // } else {
                //     //$('.result-cnt').width(containerWidth-refineWidth-40); 
                // }
                if (window.innerWidth > 1700)
                {
                    $('.result-select').css({"max-width":"97%"});
                }else if (window.innerWidth > 1280)
                {
                    $('.result-select').css({"max-width":"97%"});
                }
                else if (window.innerWidth > 1024 )
                {
                    $('.result-select').css({"max-width":"97%"});
                }
                else
                {
                    $('.result-select').css({"max-width":"97%"});
                } 
            }); 
        <?php  if(($_SERVER['REQUEST_METHOD']=="GET" )||($_POST))
        { ?>
             // $("#panel").animate({width: 'toggle'}, 200); 
             // $(".btn-slide").toggleClass("active"); 

             if ($('.left-td-bg').css("min-width") != '264px') {
                $('.left-td-bg').css("min-width", '36px');
                $('.acc_main').css("width", '35px');
                $("#panel").css("display","none");
             }
             else {
             $('.left-td-bg').css("min-width", '264px');
             $('.acc_main').css("width", '264px');
             $("#panel").css("display","block");
             } 
        <?php } ?>
                                        
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
    
    
    <?php include("../survey/survey.php");  ?>  
    
        <!--<script src="jquery-1.10.2.js"></script>-->
    <script src="hopscotch.js"></script>
    <script src="demo.js"></script>
    
    <script type="text/javascript" >
    $(document).ready(function(){
                
        <?php 
        
//        //Guided Tour 
//        $tourCookie = $_COOKIE['maLoginTour'];
//        $tourCookieArray=  json_decode($tourCookie,true);
//        $tourerror = json_last_error();
//        if($tourerror!=JSON_ERROR_NONE)
//        {
//            $tourCookieArray=array();
//            $tourUserCookie="";
//        }else{
//            $tourUserCookie=$tourCookieArray[$emailid]; 
//        }
        
        if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){
        if(isset($_POST["searchpe"])){?>
                hopscotch.startTour(tour, 3);
        <?php } 
           else if(isset($_POST["controlName"])) {
                   switch ($_POST["controlName"]) 
                   {
                      case 'dealperiod': ?>
                            hopscotch.startTour(tour, 5);
        <?php               break;
                      case 'industry':
                            if($_POST["industry"]==$tourIndustryId){?>
                               hopscotch.startTour(tour, 7);
        <?php               }else { ?>
                               hopscotch.startTour(tour, 6);
        <?php               } 
                            break;
                      case 'postlink':?>
                            hopscotch.startTour(tour, 14);
        <?php               break;
                      default:  ?>
                            init();
        <?php               break;
                    }
                }  
            else if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>
                    hopscotch.startTour(tour, 0);
        <?php    }else{ ?>
                      init();
        <?php } }else if($exportToExcel==0 && !isset($_SESSION["demoTour"]))  { ?>
                    hopscotch.startTour(tour, 0);
        <?php    }else if($isTour=="0")  { 
                
                ?>
                    hopscotch.startTour(tour, 0);
        <?php    }else {?> 
                    init();
        <?php } ?>
    });
            $( window ).scroll(function() {
            //hopscotch.refreshBubblePosition();
           });
           
        </script>
        
        <?php if($tourautostart!='ON' && $popup_search==0){  //$_SESSION['ma_popup_display'] != 'none' ?>
            <script>
               $(document).ready(function(){
                            $('.popup_close a').click(function(){
                                $(".popup_main").hide();
                                localStorage.removeItem("pageno");
                             });
                       
               });
            </script>
            <style>
            
.investment-form a.tooltip span{
    margin-left: 105px;
    margin-top: -23px;
}
            .export_new{margin-right:20px !important;}
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
    width:746px;
    height: 0;
    position: absolute;
    left:0px;
    right:0px;
    bottom:0px;
    top:0px;
    margin: auto;
      
}
.popup_header
{
    background: #414141;
    color: #fff;
    font-size: 18px;
    padding: 12px 0 12px 18px;
    margin: 0px;
}
.popup_content
{
    background: #ececec;
    padding: 24px 23px 0;   
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
     background: url("<?php echo $refUrl; ?>images/polygon1.png") no-repeat 95% center;
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
    right:20px;
    font-size: 15px;
    position:absolute;
    top:12px;   
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
}
div.token-input-dropdown{
        z-index: 999 !important;
}
</style>
<div class="popup_main">
            <div class="popup_box">
  <h1 class="popup_header">Quick Search</h1>
  <span class="popup_close"><a href="javascript: void(0);">X</a></span>
  <div class="popup_content">
      <form name="searchallleftmenu12" action="<?php echo $actionlink; ?>" method="post" id="searchallleftmenu12">   
      <div class="popup_form">
          <select class="popup_dropdown" name="popup_select" id="popup_select">
              <option value="">All</option>
              <option value="company">Target Company</option>
              <option value="sector">Target Sectors</option>
              <option value="acquirers">Acquirers</option>
              <option value="legal_advisor">Legal Advisor</option>
              <option value="transaction_advisor">Transaction Advisor</option>
         </select>
         <div class="popup_searching">
            <input type="text" name="popup_keyword" id="popup_keyword" value="" placeholder="Enter Keyword" class="popup_text" />
            <input type="hidden" name="advisor_type" id="advisor_type" value="" />
            <div id="search_load" style="  overflow-y: scroll;  max-height: 130px;  background: #fff;display:none;  width: 300px;position: absolute;top: 105px;">
                <span id="com_clearall" title="Clear All" onclick="clear_allsearch();" style="background: rgb(191, 160, 116); position: absolute; top: 29px; right: 30px; padding: 3px; display: block;">(X)</span>
            <div class="auto_keywords">
                <ul class="popup_auto_result"></ul>
           </div>
         </div>
      </div>
      </div>
      <div class="popup_btn">
             <!--<a href="javascript:void(0)" class="popup_cancel">Cancel</a>
             <a href="javascript:void(0)" class="popup_search">Search</a>-->
             <a href="javascript:void(0)" class="popup_cancel">Cancel</a>
             <input type="button" name="popup_submit" class="popup_search" value="Search" onclick="this.form.submit();">
      </div>
      </form> 
  </div>
</div>  
</div>  
        <?php //$_SESSION['ma_popup_display'] = 'none'; 
        mysql_close();
        } ?>
<script>
      $(document).ready(function () {
    
        $('#popup_keyword').keyup(function() {
        var $th = $(this);
        var popup_select =$('#popup_select').val();
        if(popup_select == "")
        {
            $th.val( $th.val().replace(/[^a-zA-Z0-9_ _ &.']/g, function(str) { alert('You typed ' + str + ' \n\nPlease use only letters, space and numbers.'); return ''; } ) );
        }
    });
});
//Added for the T-931    
$(document).ready(function(){
$countryheight=$('.countryht').height();
if($countryheight>'100')
{
    $('.result-select').addClass('countryscroll');
}else{
    $('.result-select').removeClass('countryscroll');
}
});
//Added for the T-931   
</script>
<style>
/* T-931 changes */
.countryscroll{
    height:140px;
    overflow-y:scroll;
}
</style>      



<script>
        function paginationfun(val)
        {
            $(".pagevalue").val(val);
        }
        function validpagination()
            {
                var pageval = $("#paginationinput").val();
                if(pageval == "")
                {
                    alert('Please enter the page Number...');
                    location.reload();
                }else{
                    
                }
            }
        var wage = document.getElementById("paginationinput");
        wage.addEventListener("keydown", function (e) {debugger;
            if (e.code === "Enter") {  //checks whether the pressed key is "Enter"
                //paginationForm();
                event.preventDefault();
                document.getElementById("pagination").click();

            }
        })
    </script>

    <style>
        
.paginationtextbox{
        width:6%;
        padding: 3px;
    }
        .button{
            background-color: #a2753a; /* Green */
            border: none;
            color: white;
            padding: 4px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .pageinationManual{
        display: flex;
        position: absolute;
        left: 40%;
    }
    </style>