<?php include_once("../globalconfig.php"); ?>
<?php
        require_once("reconfig.php");
        $drilldownflag=0;
        $popup_search = 0;
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $vCFlagValue=1;
        $VCFlagValue=1;
        $value=$value?$value:0;
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
         if($VCFlagValue==1)  // RE Investments
        {
                $getTotalQuery= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                FROM REinvestments AS pe, REcompanies AS pec
                WHERE pe.Deleted=0 and hideamount=0   and pe.IndustryId=15
                AND pe.PEcompanyID = pec.PECompanyId ";
                $pagetitle="PE Investments - Real Estate -> Search";
                $stagesql_search="select RETypeId,REType from realestatetypes order by REType";
                 $industrysql_search="select industryid,industry from reindustry";
                 
                $regionsql="select RegionId,Region from region where Region!='' order by RegionId";
        }
        $videalPageName="REInv";
        include ('checklogin.php');
//         include("../survey/survey.php");
         
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
        $getyear = $_REQUEST['y'];
        $getsy = $_REQUEST['sy'];
        $getey = $_REQUEST['ey'];
        $getindus = $_REQUEST['i'];
        $getstage = $_REQUEST['s'];
        $getinv = $_REQUEST['inv'];
        $getreg = $_REQUEST['reg'];
        $getrg = $_REQUEST['rg'];
        $resetfield=$_POST['resetfield'];
         // T993 
        // if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
        // {
        //     $_POST['industry']="";
        //     $_POST['stage']="";
        //     $_POST['comptype']="";
        //     $_POST['txtregion']="";
        //     $_POST['invType']="";
        //     $_POST['EntityProjectType']="";
        //     $_POST['invrangestart']="";
        //     $_POST['invrangeend']="";
        // }
       /* elseif(trim($_POST['industry'])!="" || trim($_POST['stage'])!="" || trim($_POST['comptype'])!="" || trim($_POST['txtregion'])!="" || trim($_POST['invType'])!="" || trim($_POST['EntityProjectType'])!="" || trim($_POST['invrangestart'])!="" || trim($_POST['invrangeend'])!="")
        {
            $_POST['searchallfield']="";
            $_POST['keywordsearch']="";
            $_POST['sectorsearch']="";
            $_POST['companysearch']="";
            $_POST['advisorsearch_legal']="";
            $_POST['advisorsearch_trans']="";
        }
        print_r($_POST);*/
        if(isset($_POST['popup_select'])){ 
            $month1=01; 
            $year1 = 1998;
            $month2= date('n');
            $year2 = date('Y');    
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";        
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {   
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
                $month1= date('n');
                $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                $month2= date('n');
                $year2 = date('Y');
                $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = date("Y-m-d");
            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
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
            }elseif (($resetfield=="searchallfield") || $resetfield=='searchKeywordLeft' || ($resetfield=="keywordsearch")|| ($resetfield=="sectorsearch") ||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
                if(($_POST['month1'] !='') && ($_POST['year1'] !='') && ($_POST['month2'] !='') && ($_POST['year2'] !='')){
                    $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                    $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                    $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                    $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');                
                }else{
             $month1= date('n'); 
             $year1 =  date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['searchKeywordLeft'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
            {
            
          //   if(trim($_POST['searchallfield'])!=""){
                if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                    $month1=01; 
                    $year1 = 1998;
                    $month2= date('n');
                    $year2 = date('Y');
                }else{
                    $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                    $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                    $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                    $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                }
            //    }
//                if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!=""){
//                    $month1=01; 
//                    $year1 = 1998;
//                    $month2= date('n');
//                    $year2 = date('Y');
//                }
            }
            elseif ((count($_POST['industry']) > 0) || (count($_POST['stage']) > 0) || ($_POST['comptype']!="--") || ($_POST['invType']!="--") 
                    || ($_POST['txtregion']!="--") || ($_POST['citysearch']!="")  || ($_POST['invType']!="--") || ($_POST['invrangestart']!="--")
                    || ($_POST['invrangeend']!="--")|| ($_POST['exitstatus']!="--") )
            {
                if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                    $month1=01; 
                    $year1 = 1998;
                    $month2= date('n');
                    $year2 = date('Y');
                }else{
                    $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                    $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                    $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                    $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                }
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : 01;
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));;
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
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
  
        if($compId==$companyId)
        { 
           $hideIndustry = " and display_in_page=1 "; 

        }
        else
        {
           $hideIndustry="";     
        }
       
        
       
        if ($totalrs = mysql_query($getTotalQuery))
        {
         While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
           {
                        $totDeals = $myrow["totaldeals"];
                        $totDealsAmount = $myrow["totalamount"];
                        $totalAmount=round($totDealsAmount, 0);
                        $totalAmount=number_format($totalAmount);

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
               
                            $_POST['keywordsearch'] = "";   $_POST['investorauto']="";
                            $_POST['companysearch'] = "";   $_POST['companyauto']="";
                            $_POST['sectorsearch'] = "";    $_POST['sectorauto']=""; 
                            $_POST['advisorsearch_legal'] = "";
                            $_POST['advisorsearch_trans'] = "";
                        }
        }
        $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
        
        if($resetfield=="keywordsearch")
        { 
            $_POST['keywordsearch']="";
            $keyword="";
            $keywordhidden="";
            
             $investorauto='';
        }
        else 
        {
            $keyword=trim($_POST['keywordsearch']);
            $keywordhidden=trim($_POST['keywordsearch']);
            if($keyword!=''){
                $searchallfield='';
        }
            
              if(isset($_POST['investorauto'])){
                $investorauto = $keyword=trim($_POST['investorauto']);
                $keywordhidden=trim($_POST['investorauto']);
            }else{
                if(isset($_POST['popup_select']) && $_POST['popup_select']=='investor'){
                    $investorauto = $keyword=trim(implode(',', $_POST['search_multi']));//trim($_POST['popup_keyword']);
                    $keywordhidden=trim($_POST['popup_keyword']);
                }else{
                    $investorauto = $keyword=$keywordhidden='';
        }
            } 
             $sql_investorauto_sug = "select  InvestorId as id,Investor as name from REinvestors where InvestorId IN($keyword) order by InvestorId";
            
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

        if($resetfield=="companysearch")
        { 
            $_POST['companysearch']="";
            $companysearch="";
            $companyauto='';
        }
        else 
        {
            $companysearch=trim($_POST['companysearch']);
            if($companysearch!=''){
                $searchallfield='';
            }else if(isset($_POST['popup_select']) && $_POST['popup_select']=='company'){
                $companysearch = trim(implode(',', $_POST['search_multi']));//trim($_POST['popup_keyword']);
                $sql_company = "select  PECompanyId as id,companyname as name from REcompanies where PECompanyId IN($companysearch)";
            
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
            }
            $companyauto=$_POST['companyauto'];
        }
        $companysearchhidden=ereg_replace(" ","_",trim($_POST['popup_keyword']));

        if($resetfield=="sectorsearch")
        { 
            $_POST['sectorsearch']="";
            $sectorsearch="";
        }
        else 
        {
            $sectorsearch=stripslashes(trim($_POST['sectorsearch']));
            if($sectorsearch!=''){
                $searchallfield='';
            }else if(isset($_POST['popup_select']) && $_POST['popup_select']=='sector'){
                $sectorsearch = trim(implode(',', $_POST['search_multi']));//trim($_POST['popup_keyword']);
        }
        }
        $sectorsearchhidden=ereg_replace(" ","_",$_POST['popup_keyword']);

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
                
                $advisorsql= "select cianame from REadvisor_cias where CIAId IN ( $advisorsearchstring_legal_id )";

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
                        $advisorsearchstring_legal.= $myrow["cianame"];
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
                $advisorsql= "select cianame from REadvisor_cias where CIAId IN ( $advisorsearchstring_trans_id )";

                if ($advisorrs = mysql_query($advisorsql))
                {
                    $ti = 0;
                    While($myrow=mysql_fetch_array($advisorrs, MYSQL_BOTH))
                    {
                        if( $ti != 0 ) {
                            $transaction_filter .= ',';
                            $advisorsearchstring_trans .= ',';
                        }
                        $advisorsearchstring_trans .= $myrow["cianame"];
                        $transaction_filter .= $myrow["cianame"];
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

        $industry = array();
        if($resetfield=="industry")
        { 
            $_POST['industry']="";
            $industry=[];
        }
        else 
        {
            $industry=$_POST['industry'];
            if(!empty($industry) && count($industry)>0){
                if( count($industry) == 1 ) {
                    if( $industry[0] != 15 ) {
                        $searchallfield='';
                    } else {
                        unset( $_POST[ 'industry' ] );
                    }
                }
            }
        }
         $stageval = array();
        if($resetfield=="stage")
        { 
            $_POST['stage']="";
            $stageval=[];
        }
        else 
        {
            $stageval=$_POST['stage'];
            if(!empty($stageval) && count($stageval)>0){
                $searchallfield='';
        }

        }

        if(!empty($stageval) && count($stageval)>0)
        {
            $boolStage=true;
        }
        else
        {
            $stageval=[];
            $boolStage=false;
        }
            


        //echo "<br>**" .$stage;
        if($resetfield=="comptype")
        { 
            $_POST['comptype']="";
            $companyType="--";
        }
        else 
        {
            $companyType=trim($_POST['comptype']);
            if($companyType!='--' && $companyType!=''){
                $searchallfield='';
        }
            
        }
        if($resetfield=="invType")
        { 
            $_POST['invType']="";
            $investorType="";
        }
        else 
        {
            $investorType=trim($_POST['invType']);
            if($investorType!='--' && $investorType!=''){
                $searchallfield='';
        }
        }
        
        if($resetfield=="EntityProjectType")
        { 
            $_POST['EntityProjectType']="";
            $entityProject="--";
        }
        else 
        {
            $entityProject=trim($_POST['EntityProjectType']);
            if($entityProject!='--' && $entityProject!=''){
                $searchallfield='';
        }
        }
        if($entityProject==1)
            $entityProjectvalue="Entity";
        elseif($entityProject==2)
            $entityProjectvalue="Project";

        if($resetfield=="txtregion")
        { 
            $_POST['txtregion']="";
            $regionId="";
        }
        else 
        {
            $regionId=trim($_POST['txtregion']);
            if($regionId>0){
                $searchallfield='';
        }
        }
        
        if($resetfield=="city")
        { 
            $_POST['citysearch']="";
            $city="";
        }
        else 
        {
            $city=trim($_POST['citysearch']);
            if($city != NULL){
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
            if($startRangeValue!="--" && $endRangeValue!="--" && $startRangeValue>0 && $endRangeValue>0){
                $searchallfield='';
        }
        }
        
        $endRangeValueDisplay =$endRangeValue;
        
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
        
        if(!empty($industry) && (count($industry) > 0))
        {
            $indusSql = $industryvalue = '';
            foreach($industry as $industrys)
            {
                $indusSql .= " IndustryId=$industrys or ";
            }
            $indusSql = trim($indusSql,' or ');
            $industrysql= "select industry from reindustry where $indusSql";

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
        
        $stageCnt=0; $cnt=0;$stagevaluetext='';
        $stageCntSql="select count(RETypeId) as cnt from realestatetypes";
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
                $stagesql= "select REType from realestatetypes where RETypeId=$stageid";
                //	echo "<br>**".$stagesql;
                if ($stagers = mysql_query($stagesql))
                {
                    While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                    {
                            $cnt=$cnt+1;
                            $stagevaluetext= $stagevaluetext. ",".$myrow["REType"] ;
                    }
                }
            }
            $stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
            if($cnt == $stageCnt)
            {      $stagevaluetext="All Stages";
            
            }
        }
        else{
            $stagevaluetext="";
        }
        if($getstage !='')
        {
            $stagevaluetext = $getstage;
        }
        
        if($exitstatusValue!=''){
            
            if($exitstatusValue==1){
                
                $exitstatusfilter='Unexited';
                
            }
            else if($exitstatusValue==2){
                
                $exitstatusfilter='Partially Exited';
                
            }
            else if($exitstatusValue==3){
                
                $exitstatusfilter='Fully Exited';
                
            }
        }
        
        
        //echo "<br>Stge**" .$range;
        $whereind="";
        $whereregion="";
        $whereinvType="";
        $wherestage="";
        $wheredates="";
        $whererange="";
        $wherelisting_status="";
        $whereaddHideamount="";
        $whereexitstatus="";
     
                 
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
            
         /*   $cmonth1= 01;
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
            
            
        
            $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
            /*if($industry >0)
		{
			$industrysql= "select industry from reindustry where IndustryId=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
		}

		if($stage >0)
		{
			$stagesql= "select REType from realestatetypes where RETypeId=$stage";

			if ($stagers = mysql_query($stagesql))
			{
				While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
				{
					$stagevalue=$myrow["REType"];
				}
			}
            }*/
		
		if($regionId >0)
				{
					$regionsql= "select Region from region where RegionId=$regionId";
					if ($regionrs = mysql_query($regionsql))
					{
						While($myrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
							$regionvalue=$myrow["Region"];
						}
					}
		}

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

		if($entityProject==1)
		    $entityProjectvalue="Entity";
		elseif($entityProject==2)
		    $entityProjectvalue="Project";

                if($companyType=="L")
		        $companyTypeDisplay="Listed";
		elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
 	        elseif($companyType=="--")
                        $companyTypeDisplay="";
            
                if($vcflagValue==0)
                {
                        /*$addVCFlagqry = " and pec.industry =15 ";*/
                        $addVCFlagqry = " and pe.IndustryId =15 ";
                        //$addVCFlagqry = "";
                        $checkForStage = ' && ('.'$stage'.' =="--")';
                        //$checkForStage = " && (" .'$stage'."=='--') ";
                        $checkForStageValue = " || (" .'$stage'.">0) ";
                        $searchTitle = "List of PE Investments ";
                        $searchAggTitle = "Aggregate Data - PE Investments ";
                        $aggsql= "select count(PEId) as totaldeals,sum(amount) as totalamount from peinvestments as pe,
                        recompanies as pec,industry as i where ";
                }
                elseif($vcflagValue==1)
                {
                        //$addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";
                        /*$addVCFlagqry = " and s.VCview=1 and pe.amount <=20 and pec.industry =15";*/
                        $addVCFlagqry = " and s.VCview=1 and pe.amount <=20 and pe.IndustryId =15";

                        $checkForStage = '&& ('.'$stage'.'=="--") ';
                        //$checkForStage = " && (" .'$stage'."=='--') ";
                        $checkForStageValue =  " || (" .'$stage'.">0) ";
                        $searchTitle = "List of VC Investments ";
                        $searchAggTitle = "Aggregate Data - VC Investments ";
                        $aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                        FROM REinvestments AS pe,REcompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
                //	echo "<br>Check for stage** - " .$checkForStage;
                }
                elseif($vcflagValue==2)
                {
                        /*$addVCFlagqry = " and pec.industry =15 ";*/
                        $addVCFlagqry = " and pe.IndustryId =15 ";
                        $checkForStage = "";
                        $checkForStageValue = "";
                        $searchTitle = "List of PE Investments - Real Estate";
                        $searchAggTitle = "Aggregate Data - PE Investments - Real Estate";
                        $aggsql= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                        FROM REinvestments AS pe, REcompanies AS pec,industry as i where	";
                }
                    $orderby=""; $ordertype="";
                    //T993
            //   if(!$_POST || $companysearch != "" || $sectorsearch !='' || $keyword !="" || $advisorsearchstring_legal !='' || $advisorsearchstring_trans !='') {
                    
            //     $stagevaluetext = '';
            //     $valuationstxt = '';
            //     $getrangevalue = '';
            //     $getinvestorvalue = '';
            //     $getregionevalue = '';
            //     $getindusvalue = '';
            //     $datevalueCheck1 = '';
            //     $round ="--";
            //     $companyType = '--';
            //     $investorType = '--';
            //     $regionId = 0;
            //     $city = '';
            //     $startRangeValue = '--';
            //     $endRangeValue = '--';
            //     $exitstatusValue = '';
            //     $debt_equity = '--';
            //     $syndication ="--";   
            //     $stageval = $valuations = array();
            //    }
                    if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
                            $companysql = "SELECT pe.PECompanyID AS PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector ,
                                amount, round, s.REType, stakepercentage, DATE_FORMAT( dates,  '%b-%Y' ) AS dealperiod, pec.website, pec.region, 
                                pe.PEId, pe.COMMENT , pe.MoreInfor, pe.hideamount, pe.hidestake, pe.StageId, pe.SPV, pe.city AS dealcity, pe.AggHide,pe.dates as dates,pe.Exit_Status,
                                 (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
                                FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec, realestatetypes AS s
                                WHERE dates BETWEEN  '" . $getdt1. "' and '" . $getdt2 . "' AND i.industryid = pe.IndustryId AND pec.PEcompanyID = pe.PECompanyID
                                AND pe.StageId = s.RETypeId AND r.RegionId = pe.RegionId ".$getind." ".$getst." ".$getinvest." ".$getregion." ".$getrange." and pe.Deleted=0" .$addVCFlagqry. "  
                                GROUP BY pe.PEId ";
                              // echo "<br>all dashboard" .$companysql;
                             $orderby="dates";
                            $ordertype="desc";
                        }
                      
                        else if(!$_POST){
                            $yourquery=0;
                               $dt1 = $year1."-".$month1."-01";
                               $dt2 = $year2."-".$month2."-31";
				 $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector,
				 amount, round, s.REType,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod, pec.website,
				pe.PEId,pe.comment,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.city as dealcity,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
						 FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
						 WHERE pe.IndustryId = i.industryid
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and 
                                                 pe.Deleted=0" .$addVCFlagqry." and dates between '" . $dt1. "' and '" . $dt2 . "'  
                                                 GROUP BY pe.PEId ";
                               
                                  $orderby="dates";
                            $ordertype="desc";
				   //echo "<br>all records" .$companysql;
			}
                        elseif ($searchallfield != "")
			{
			    $yourquery=1;
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";   
                                
                                /*$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				pec.website, pec.city, pec.region, pe.PEId,
				pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.city as dealcity,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
                                FROM REinvestments AS pe, reindustry AS i,
				REcompanies AS pec,realestatetypes as s,REinvestors AS REinv, REinvestments_investors AS REinvoinv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and pe.Deleted =0 AND REinvoinv.PEId = pe.PEId AND REinv.InvestorId = REinvoinv.InvestorId AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
				OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or REinv.Investor like '$searchallfield%' or pe.ProjectName like '$searchallfield%'     )  
                                GROUP BY pe.PEId ";*/
                                $searchExplode = explode( ' ', $searchallfield );
                                foreach( $searchExplode as $searchFieldExp ) {

                                    $cityLike .= "pec.city REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                   /* $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";*/
                                    $sectorLike .= "pe.sector REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $moreInfoLike .= "pe.MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $investorLike .= "REinv.Investor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $projectLike .= "pe.ProjectName REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $cianameLike .= "reacai.Cianame REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                }

                                $cityLike = '('.trim($cityLike,'AND ').')';
                                $companyLike = '('.trim($companyLike,'AND ').')';
                                $sectorLike = '('.trim($sectorLike,'AND ').')';
                                $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
                                $investorLike = '('.trim($investorLike,'AND ').')';
                                $projectLike = '('.trim($projectLike,'AND ').')';
                               /* $cianameLike = '('.trim($cianameLike,'AND ');*/
                               $cianameLike = trim($cianameLike,'AND ');
                                 $cianameLike = "( select count(*) from REadvisorcompanies_advisorinvestors as reacai where reacai.PEId=REinvoinv.PEId and  reacai.dates between '" . $dt1. "' and '" . $dt2 . "' and ".$cianameLike.")";
                               
                                //$tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%' or pec.tags REGEXP '[[.colon.]]$searchallfield$' or pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                                $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike . ' OR ' . $projectLike . ' OR ' . $cianameLike;                                    
                               
                               /* $companysql="SELECT pe.PEId,pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( pe.dates, '%b-%Y' ) as dealperiod ,
				pec.website, pec.city, pec.region, 
				pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.city as dealcity,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
                                FROM REinvestments AS pe, reindustry AS i,
				REcompanies AS pec,realestatetypes as s,REinvestors AS REinv, REinvestments_investors AS REinvoinv, REadvisorcompanies_advisorinvestors as reacai
                                WHERE pe.dates between '" . $dt1. "' and '" . $dt2 . "' and pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and pe.Deleted =0 " .$addVCFlagqry. " AND REinvoinv.PEId = pe.PEId AND REinv.InvestorId = REinvoinv.InvestorId AND ( $tagsval   and  reacai.dates between '" . $dt1. "' and '" . $dt2 . "'  AND reacai.PEId=REinvoinv.PEId))
                                GROUP BY pe.PEId ";
                                $orderby="dates";
                                $ordertype="desc";
                                $popup_search = 1;*/
                                 $companysql="SELECT pe.PEId,pe.PECompanyId, pec.companyname, pec.industry, i.industry, pe.sector,
                pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( pe.dates, '%b-%Y' ) as dealperiod ,
                pec.website, pec.city, pec.region, 
                pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.city as dealcity,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
                                FROM REinvestments AS pe, reindustry AS i,
                REcompanies AS pec,realestatetypes as s,REinvestors AS REinv, REinvestments_investors AS REinvoinv, REadvisorcompanies_advisorinvestors as reacai
                                WHERE pe.dates between '" . $dt1. "' and '" . $dt2 . "' and pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and pe.Deleted =0 " .$addVCFlagqry. " AND REinvoinv.PEId = pe.PEId AND REinv.InvestorId = REinvoinv.InvestorId AND ( $tagsval)
                                GROUP BY pe.PEId ";
                                $orderby="dates";
                                $ordertype="desc";
                                $popup_search = 1;
                            //	echo "<br>Query for company search";
                            //                       echo "<br> Company search--" .$companysql;
                            //                       exit();
			}
			elseif ($companysearchold != "")//T-993 changed variable name
			{
                            if(isset($_POST['popup_select']) && $_POST['popup_select']=='company'){
                                $keyaft=" (".$trend_com_qry.")";                                                
                            }else{
                                $keyaft=" pec.PECompanyId IN ($companysearch) ";
                            }
			    $yourquery=1;
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";   
				$companysql="SELECT pe.PECompanyId  as PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector,
				pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,
				pec.website, pec.city, pe.PEId,
				pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.city as dealcity,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
				FROM REinvestments AS pe, reindustry AS i,
				REcompanies AS pec,realestatetypes as s
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND  $keyaft 
				GROUP BY pe.PEId ";
                                 $orderby="dates";
                            $ordertype="desc";
                            $popup_search = 1;
			//	echo "<br>Query for company search";
			// echo "<br> Company search--" .$companysql;
			}
                        elseif ($sectorsearchold != "")//T-993 changed variable name
			{
                             $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                                            $sector_sql = array(); // Stop errors when $words is empty
                            $sectors_filter = '';

                                            foreach($sectorsearchArray as $word){
                                                $word =trim($word);
//                                                $sector_sql[] = " sector_business LIKE '$word%' ";
                                               /* $sector_sql[] = " sector_business = '$word' ";
                                                $sector_sql[] = " sector_business LIKE '$word(%' ";
                                                $sector_sql[] = " sector_business LIKE '$word (%' ";*/
                                                $sector_sql[] = " sector = '$word' ";
                                                $sector_sql[] = " sector LIKE '$word(%' ";
                                                $sector_sql[] = " sector LIKE '$word (%' ";
                                $sectors_filter.= $word.',';
                                            }
                            $sectors_filter = trim($sectors_filter,',');
                                            $sector_filter = implode(" OR ", $sector_sql);
                            
                            
			    $yourquery=1;
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";   
				$companysql="SELECT pe.PECompanyId  as PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector,
				pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,
				pec.website, pec.city, pe.PEId,
				pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.city as dealcity,pe.AggHide,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
				FROM REinvestments AS pe, reindustry AS i,
				REcompanies AS pec,realestatetypes as s
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND  ($sector_filter) 
                                GROUP BY pe.PEId ";
                                 $orderby="dates";
                            $ordertype="desc";
                            $popup_search = 1;
			//	echo "<br>Query for company search";
			// echo "<br> Company search--" .$companysql;
			}
			elseif($keywordold!="")//T-993 changed variable name
			{
                            if(isset($_POST['popup_select']) && $_POST['popup_select']=='investor'){
                                $keyaft=" (".$inv_qry.")";  
                                 $keywordsearch = $_POST['popup_keyword'];                                              
                            }else{
                                $keywordsearch = $_POST['keywordsearch'];
                                $keyaft=" REinv.InvestorId IN ($keywordsearch)";
                            }
                            
			    $yourquery=1;
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";   
				$companysql="select pe.PECompanyId  as PECompanyId,pec.companyname,pe.IndustryId,i.industry,pe.sector,pe.amount,pec.industry,
				pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,i.industry,hideamount,pe.SPV,s.REType,pe.city as dealcity,pe.AggHide,pe.dates as dates,pe.Exit_Status, pe.PEId,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
                                from REinvestments as pe,REcompanies as pec,reindustry as i,realestatetypes as s,REinvestors AS REinv, REinvestments_investors AS REinvoinv
                                where  dates between '" . $dt1. "' and '" . $dt2 . "' and  pe.IndustryId = i.industryid and  pe.StageId=s.RETypeId and pe.Deleted=0 AND REinvoinv.PEId = pe.PEId AND REinv.InvestorId = REinvoinv.InvestorId
                                and pec.PECompanyId=pe.PECompanyId " .$addVCFlagqry." AND $keyaft
                                GROUP BY pe.PEId ";
                                 $orderby="dates";
                            $ordertype="desc";
                            $popup_search = 1;
			//echo "<br> Investor search- ".$companysql;
			}
			elseif($advisorsearchstring_legal!="")
			{
			    $yourquery=1;
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";   
			$companysql="(
				SELECT peinv.PEId,peinv.PECompanyId  as PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,peinv.SPV,peinv.city as dealcity,peinv.AggHide ,DATE_FORMAT( peinv.dates, '%b-%Y' ) as dealperiod,peinv.dates as dates,peinv.Exit_Status,
                                (SELECT GROUP_CONCAT( REinv.Investor ) FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv WHERE REinvoinv.PEId = peinv.PEId AND REinv.InvestorId = REinvoinv.InvestorId) AS Investor
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  peinv.Deleted=0 and c.industry =15 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
				AND ( " . $legalWhereCond . " )  GROUP BY peinv.PEId
				)
				UNION (
				SELECT peinv.PEId,peinv.PECompanyId  as PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,peinv.AggHide,DATE_FORMAT( peinv.dates, '%b-%Y' ) as dealperiod,peinv.dates as dates,peinv.Exit_Status,
                                (SELECT GROUP_CONCAT( REinv.Investor ) FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv WHERE REinvoinv.PEId = peinv.PEId AND REinv.InvestorId = REinvoinv.InvestorId) AS Investor
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and peinv.Deleted=0 and c.industry =15 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
				AND ( " . $legalWhereCond . " ) GROUP BY peinv.PEId
				)";
                         $orderby="companyname";
                         $ordertype="asc";
                         $popup_search = 1;
			//echo "<Br>ADvisor search--" . $companysql;
			}
			elseif($advisorsearchstring_trans!="")
			{
			    $yourquery=1;
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";   
			$companysql="(
				SELECT peinv.PEId,peinv.PECompanyId  as PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,peinv.SPV,peinv.city as dealcity,peinv.AggHide ,DATE_FORMAT( peinv.dates, '%b-%Y' ) as dealperiod,peinv.dates as dates,peinv.Exit_Status,
                                (SELECT GROUP_CONCAT( REinv.Investor ) FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv WHERE REinvoinv.PEId = peinv.PEId AND REinv.InvestorId = REinvoinv.InvestorId) AS Investor
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  peinv.Deleted=0 and c.industry =15 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
				AND (". $transWhereCond .") GROUP BY peinv.PEId
				)
				UNION (
				SELECT peinv.PEId,peinv.PECompanyId  as PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,peinv.AggHide ,DATE_FORMAT( peinv.dates, '%b-%Y' ) as dealperiod,peinv.dates as dates,peinv.Exit_Status,
                                (SELECT GROUP_CONCAT( REinv.Investor ) FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv WHERE REinvoinv.PEId = peinv.PEId AND REinv.InvestorId = REinvoinv.InvestorId) AS Investor
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  peinv.Deleted=0 and c.industry =15 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
				AND (". $transWhereCond .") GROUP BY peinv.PEId
				)";
                         $orderby="companyname";
                         $ordertype="asc";
                         $popup_search = 1;
				//echo "<Br>Trans search--" . $companysql;
		       }
                      
			elseif ((count($industry) > 0) ||$companysearch != "" ||  $sectorsearch != "" || $keyword !="" || ($invType !="--") || ($companyType!="--") || ($regionId> 0) || ($city != "") ||  ($entityProject!="--") || ($startRangeValue == "--") || ($endRangeValue == "--") || ( ($exitstatusValue!='' && $exitstatusValue!='--')) || (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--")) .$checkForStageValue)
				{
				    $yourquery=1;

					$dt1 = $year1."-".$month1."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					 //T-993
                     $companysql = "select pe.PECompanyID  as PECompanyId,pec.companyname,pe.IndustryId,i.industry,
                     pe.sector,pe.amount,pe.round,s.REType,pe.stakepercentage,DATE_FORMAT(pe.dates,'%b-%Y') as dealperiod,
                     pec.website,pec.region,pe.PEId,pe.comment,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,AggHide,pe.city as dealcity,pe.dates as dates,pe.Exit_Status,
                                         (SELECT GROUP_CONCAT( inv.Investor ) FROM REinvestments_investors AS peinv, REinvestors AS inv WHERE peinv.PEId = pe.PEId AND inv.InvestorId = peinv.InvestorId) AS Investor
                     from REinvestments as pe, reindustry as i,REcompanies as pec,realestatetypes as s,region as r,REinvestors AS REinv, REinvestments_investors AS REinvoinv
                                         where";
                                         //T-993
                //	echo "<br> individual where clauses have to be merged ";
                 //T-993
                 if($keyword !=""){
                    if(isset($_POST['popup_select']) && $_POST['popup_select']=='investor'){
                        $keyaft=" and (".$inv_qry.")";
                       // $keywordsearch = $_POST['popup_keyword'];   
                        $keywordsql="select REinv.InvestorId from REinvestors as REinv where ".$inv_qry;  
                        $keyall=mysql_query($keywordsql);
                        while($myrow=mysql_fetch_array($keyall, MYSQL_BOTH)){
                            $keywordsearch=$myrow[0];
                        }
                                                                  
                    }else{
                        $keywordsearch = $_POST['keywordsearch'];
                        $keyaft=" and  REinv.InvestorId IN ($keywordsearch)";
                    }
                }
                if($sectorsearch!=""){
                    $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                    $sector_sql = array(); // Stop errors when $words is empty
                    $sectors_filter = '';

                    foreach($sectorsearchArray as $word){
                        $word =trim($word);
    //                                                $sector_sql[] = " sector_business LIKE '$word%' ";
                    /* $sector_sql[] = " sector_business = '$word' ";
                        $sector_sql[] = " sector_business LIKE '$word(%' ";
                        $sector_sql[] = " sector_business LIKE '$word (%' ";*/
                        $sector_sql[] = " sector = '$word' ";
                        $sector_sql[] = " sector LIKE '$word(%' ";
                        $sector_sql[] = " sector LIKE '$word (%' ";
                        $sectors_filter.= $word.',';
                    }
                    $sectors_filter = trim($sectors_filter,',');
                    $sector_filter = implode(" OR ", $sector_sql);
                }
                if($companysearch !=""){
                    if(isset($_POST['popup_select']) && $_POST['popup_select']=='company'){
                        $keyaftcom=" and (".$trend_com_qry.")";                                                
                    }else{
                        $keyaftcom=" and  pec.PECompanyId IN ($companysearch) ";
                    }
                }

                //T-993
					if (count($industry) > 0 && $industry[0]!='')
                                        {
                                            $indusSql = '';
                                            foreach($industry as $industrys)
                                            {
                                                $indusSql .= " pe.IndustryId=$industrys or ";
                                            }
                                            $indusSql = trim($indusSql,' or ');
                                            if($indusSql !=''){
                                                $whereind = ' ( '.$indusSql.' ) ';
                                            }
                                                $qryIndTitle="Industry - ";
                                            $addVCFlagqry='';
                                        }
                //	echo "<br> WHERE IND--" .$whereind;
                                        if ($regionId > 0 )
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pe.RegionId= $regionId ";
                                        }
                                        if($city != "")
                                        {
                                            $whereCity=" pe.city LIKE '".$city."%' ";
                                        }
                                //	echo " <bR> where REGION--- " .$whereregion;
                                        if($companyType!="--" && $companyType!="")
                                        {
                                          $wherelisting_status=" pe.listing_status='".$companyType."'";
                                          }
                                        if ($investorType !="--" && $investorType!="" && $investorType!=" ")
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType ='".$investorType."'";
                                        }


                                        if ($boolStage==true)
                                        {
                                                $stagevalue="";
                                                foreach($stageval as $stage)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                }
                                                $stageidvalue = implode($stageval,',');
                                                $wherestage = $stagevalue ;
                                                $qryDealTypeTitle="Stage  - ";
                                                $strlength=strlen($wherestage);
                                                $strlength=$strlength-3;
                                        //echo "<Br>----------------" .$wherestage;
                                        $wherestage= substr ($wherestage , 0,$strlength);
                                        $wherestage ="(".$wherestage.")";
                                        //echo "<br>---" .$stringto;

                                        }

                                        if($entityProject==1)
                                                $whereSPVCompanies=" pe.SPV=0";
                                        elseif($entityProject==2)
                                                $whereSPVCompanies=" pe.SPV=1";


                                                
                                        
                                          if( ($startRangeValue>0 && $endRangeValue=="--") || ($startRangeValue > $endRangeValue) || ($startRangeValue == $endRangeValue) )
                                                {
                                                     $endRangeValue=$endRangeValueDisplay=5000;
                                                }
                                                
                                              
                                //	echo "<br>Where stge---" .$wherestage;
                                        if (($startRangeValue!= "") && ($startRangeValue!= "--") && ($endRangeValue != ""))
                                        {
                                                $startRangeValue=$startRangeValue;
                                                $endRangeValue=$endRangeValue-0.01;
                                                $qryRangeTitle="Deal Range (M$) - ";
                                                if($startRangeValue < $endRangeValue)
                                                {
                                                        $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue;
                                                }
                                                elseif($startRangeValue = $endRangeValue)
                                                {
                                                        $whererange = " pe.amount >= ".$startRangeValue;
                                                }
                                        }
                                        else if ($startRangeValue== "--" && $endRangeValue > 0){

                                                $startRangeValue=0;
                                                $endRangeValue=$endRangeValue-0.01;
                                                $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue;
                                            
                                        }else if ($startRangeValue== "" && $endRangeValue > 0){

                                            $startRangeValue=0;
                                            $endRangeValue=$endRangeValue-0.01;
                                            $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue;
                                        
                                    }

                                        
                                         if($exitstatusValue!='' && $exitstatusValue !='--'){
                                            $whereexitstatus= " Exit_Status = $exitstatusValue";
                                            
                                        }
                                        

                                        if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                        {
                                                $qryDateTitle ="Period - ";
                                                $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";

                                        }
					if ($whereind != "")
						{
							$companysql=$companysql . $whereind ." and ";
							$aggsql=$aggsql . $whereind ." and ";
							$bool=true;
						}
						else
						{
							$bool=false;
						}
					if($whereregion!="")
					{
						$companysql=$companysql .$whereregion . " and ";
					}
                                        if($whereCity !="")
                                        {
                                            $companysql=$companysql.$whereCity." and ";
                                        }
					if (($wherestage != ""))
						{
							$companysql=$companysql . $wherestage . " and " ;
							$aggsql=$aggsql . $wherestage ." and ";
							$bool=true;
						}

					if (($whereInvType != "") )
						{
							$companysql=$companysql .$whereInvType . " and ";
							$aggsql = $aggsql . $whereInvType ." and ";
							$bool=true;
						}
					if (($whereSPVCompanies != "") )
						{
							$companysql=$companysql .$whereSPVCompanies . " and ";
							$aggsql = $aggsql . $whereSPVCompanies ." and ";
							$bool=true;
						}
					if($wherelisting_status!="")
                                        	{
                                                 $companysql=$companysql .$wherelisting_status . " and ";
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

                                        if($whereexitstatus!=""){
                                            
                                            $companysql=$companysql .$whereexitstatus . " and ";
                                            $aggsql=$aggsql .$whereexitstatus . " and ";
                                            $bool=true;
                                            
                                        }
                     // T993
                    if($sector_filter != ''){
                        $sector_filter_valid = " and (".$sector_filter.")";
                    }else{
                        $sector_filter_valid = "";
                    }                   
					//the foll if was previously checked for range
					if($whererange  !="")
					{
						 //T-993
                         $companysql = $companysql . "   i.industryid=pe.IndustryId and
                         pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and r.RegionId=pe.RegionId and
                         pe.Deleted=0 and REinvoinv.PEId = pe.PEId AND REinv.InvestorId = REinvoinv.InvestorId" . $addVCFlagqry.$keyaft.$keyaftcom.$sector_filter_valid." GROUP BY pe.PEId  ";
                                                  $orderby="dates";
                                                  $ordertype="desc";
					//	echo "<br>----" .$whererange;
					}
					elseif($whererange!="--")
					{
						//T-993
						$companysql = $companysql . "  i.industryid=pe.IndustryId and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and r.RegionId=pe.RegionId and
						pe.Deleted=0 and REinvoinv.PEId = pe.PEId AND REinv.InvestorId = REinvoinv.InvestorId" .$addVCFlagqry.$keyaft.$keyaftcom.$sector_filter_valid."  GROUP BY pe.PEId  ";
                                                 $orderby="dates";
                                                 $ordertype="desc";
                         //T-993
				//		echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
					}
                                        
                                        $popup_search = 1;
                                   // echo "<br>^^^".$companysql;
				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
        $orderby="companyname";
        $ordertype="asc";                        
        $ajaxcompanysql=  urlencode($companysql);
       if($companysql!="" && $orderby!="" && $ordertype!="")
           $companysql = $companysql . " order by  dates desc,companyname asc "; 
	//END OF POST
        $topNav = 'Deals';
        $defpage=$vcflagValue;
        $investdef=1;
        $stagedef=1;
      include_once('reindex_search.php');
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
      <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active" id="openRefine">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('rerefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
    </div>
</div>
</td>
 <?php
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
                                                
                        if ($companyrsall = mysql_query($companysql))
                        {
                            $company_cntall = mysql_num_rows($companyrsall);
                        } 

                        if ($company_cntall>0)
                          {
                                $hidecount=0;
                                $acrossDealsCnt=0;
                                 mysql_data_seek($companyrs,0);
                                 $icount = 0;
                                if ($_SESSION['resultId']) 
                                   unset($_SESSION['resultId']); 
                                 if ($_SESSION['resultCompanyId']) 
                                   unset($_SESSION['resultCompanyId']); 
                           While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                                {
                                        $amtTobeDeductedforAggHide=0;
                                        $prd=$myrow["dealperiod"];
                                        if($myrow["AggHide"]==1)
                                        {
                                                $amtTobeDeductedforAggHide=$myrow["amount"];
                                                $NoofDealsCntTobeDeducted=1;
                                        }
                                        else
                                        {
                                                $amtTobeDeductedforAggHide=0;
                                                $NoofDealsCntTobeDeducted=0;
                                        }
                                        if($myrow["hideamount"]==1)
                                        {
                                                $hideamount="--";
                                                $hidecount=$hidecount+1;
                                        }
                                        else
                                        {
                                                $hideamount=$myrow["amount"];
                                        }


                                        $companyName=trim($myrow["companyname"]);
                                        $companyName=strtolower($companyName);
                                        $compResult=substr_count($companyName,$searchString);
                                        $compResult1=substr_count($companyName,$searchString1);

                                        if($myrow["amount"]==0)
                                        {
                                                $hideamount="";
                                                $amountobeAdded=0;
                                        }
                                        if($myrow["hideamount"]==1)
                                        {
                                                $hideamount="";
                                                $amountobeAdded=0;

                                        }
                                        elseif($myrow["hideamount"]==0)
                                        {
                                                $hideamount=$myrow["amount"];
                                                $acrossDealsCnt=$acrossDealsCnt+1-$NoofDealsCntTobeDeducted;
                                                $amountobeAdded=$myrow["amount"];
                                        }
                                        if(($compResult==0) && ($compResult1==0))
                                        {
                                                //Session Variable for storing Id. To be used in Previous / Next Buttons
                                                $_SESSION['resultId'][$icount] = $myrow["PEId"];
                                                $_SESSION['resultCompanyId'][$icount] = $myrow["PECompanyId"];
                                                $icount++;
                                        }
                                        $industryAdded = $myrow[2];
                                       /* $totalInv=$totalInv+1;
                                        $totalAmount=$totalAmount+ $amountobeAdded;*/
                                        
                                        
                                        $totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;

                                        //$totalAmount=$totalAmount+ $myrow["amount"];
                                        $totalAmount=$totalAmount+ $amountobeAdded - $amtTobeDeductedforAggHide;

                                }
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
                         $companysqlwithlimit=$companysql." limit $offset, $rec_limit";
                         if ($companyrs = mysql_query($companysqlwithlimit))
                         {
                             $company_cnt = mysql_num_rows($companyrs);
                         }
                                     //$searchTitle=" List of Deals";
                        }
                        else
                        {
                             $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                             $notable=true;
                             writeSql_for_no_records($companysql,$emailid);
                        }
		           ?>
<td class="profile-view-left" style="width:100%;">
    <div class="result-cnt">
        <?php if ($accesserror==1){?>
            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm">Click here</a></b></div>
                <?php
        exit; 
        } 
        ?>

        <div class="result-title">
              <div class="filter-key-result">  
              <div style="float: left; margin: 10px 10px 0px 0px;font-size: 20px;">
                <a  class="help-icon tooltip"><strong>Note</strong>
                    <span>
                        <img class="showtextlarge" src="img/callout.gif">
                        Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.
                        Target/Company in [] indicates a debt investment. Not included in aggregate data.
                    </span>
                </a> 
            </div>
                    <div class="lft-cn" style="max-width:95%"> 
                                            
                        	<?php if(!$_POST){  ?>
                                <ul class="result-select closetagspace">
                                <li>
                                    <?php echo "Real Estate"; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                   <?php
                                if($stagevaluetext!=""){  ?>
                                          
                                              <li> 
                                                <?php echo $stagevaluetext;?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          
                                <?php }
                                 if (($getrangevalue!= "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$getrangevalue; ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }else{ ?>
                                    <li> 
                                        <?php echo "(USM) 0-5000"; ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                                    if($city!=""){ $drilldownflag=0; ?>
                                     <!-- City -->
                                    <li> 
                                        <?php echo $city; ?><a  onclick="resetinput('city');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                <?php }
                                        if($getindusvalue!=""){  ?>
                                          
                                              <li> 
                                                <?php echo $getindusvalue;?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                <?php }
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
                                      <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?>
                                    </li>
                                <?php 
                                }
                                ?>
                               </ul>
                              <?php            
                              }
                            else 
                            { ?>         
                            <ul class="result-select closetagspace" >
                                <?php
                                $_POST['resetfield']="";
                                foreach($_POST as $value1 => $link) 
                                { 
                                    if($link == "" || $link == "--" || $link == " ") 
                                    { 
                                        unset($_POST[$value1]); 
                                    } 
                                }
                                //print_r($_POST);
                                $cl_count = count($_POST);
                                if($cl_count >= 4)
                                {
                                ?>
                                <li class="result-select-close">
                                <?php 
                                if(GLOBAL_BASE_URL=='https://www.ventureintelligence.asia/dev/'){
                                ?>                                
                                <a href="reindex.php" id="allfilterclear" onmouseover="searchcloseover();" onmouseout="searchcloseout();"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                                <?php }else{ ?>
                                    <a href="/re/reindex.php" id="allfilterclear" onmouseover="searchcloseover();" onmouseout="searchcloseout();"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                            }
                                
                                if(count($industry) >0 && !empty($industry)){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }else{ ?>
                                    <li>
                                    <?php echo "Real Estate"; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                    
                                <?php } 
                                if($stagevaluetext!="" && $stagevaluetext!=null) { $drilldownflag=0;?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companyType!="--" && $companyType!=null){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $companyTypeDisplay; ?><a  onclick="resetinput('comptype');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($investorType !="--" && $investorType!=null){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($regionId>0){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                    if($city!=""){ $drilldownflag=0; ?>
                                     <!-- City -->
                                    <li> 
                                        <?php echo $city; ?><a  onclick="resetinput('city');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                <?php }
                                if (($startRangeValue!= "--" && $endRangeValue != "") || ($startRangeValue== "--" && $endRangeValue > 0) ){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($datevalueDisplay1!=""){  ?>
                                <li> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                else if($datevalueCheck1 !="")
                                {
                                 ?>
                                 <li style="padding:1px 10px 1px 10px;"> 
                                    <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?>
                                </li>
                                <?php
                                }
                                if($entityProject!="--" && $entityProject!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $entityProjectvalue;?><a  onclick="resetinput('EntityProjectType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($keyword!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php if($invester_filter !='') echo $invester_filter; else echo $investorauto;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php if($company_filter !='') echo $company_filter; else  echo $companyauto?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  str_replace("'","",trim($sectorsearch));?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_legal!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_trans!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                               if($exitstatusfilter!=''){ ?>
                                <li> 
                                   <?php echo trim($exitstatusfilter)?><a  onclick="resetinput('exitstatus');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                
                             </ul>
                            <?php }} ?>
                        </div>
                    <div class='result-rt-cnt'>
              
                            <div class="result-count">
                              <span class="result-amount"></span>
                              <span class="result-amount-no" id="show-total-amount"></span> 
                              <span class="result-no" id="show-total-deal"> Results Found</span> 

                              <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
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
                <!--<div class="alert-note"><div class="alert-para">Note: Target in () indicates sale of SPV/ Project rather than the company.</div>
                    <div class="alert-para">Target in { } indicates an investment by an investor that is not a classic PE-RE Fund (for example, NBFCs). Such deals will not be counted for the aggregate data displayed.</div>
                    <div class="title-links " id="exportbtn"></div>
                </div> 	                               
                <div class="list-tab"><ul>
                         <li class="active"><a class="tour-lock postlink"  href="index.php?value=0"  id="icon-grid-view" onmouseover="blocktourover();" onmouseout="blocktourout();" ><i></i> List  View</a></li>
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
                      <li> <a id="icon-detailed-view" class="tour-lock postlink" href="redealdetails.php?value=<?php echo $comid;?>" onmouseover="blocktourover();" onmouseout="blocktourout();"><i></i> Detail View</a></li> 
                        </ul></div>-->
        </div></div>
                         <?php   if($notable==false)
                                { ?> 
                        <a id="detailpost" class="postlink"></a>
                        <div class="view-table view-table-list">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                                <th style="width: 40%;" class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Company</th>
                                <th style="width: 10%;" class="header <?php echo ($orderby=="dealcity")?$ordertype:""; ?>" id="dealcity">City</th>
                                <th style="width: 20%;" class="header <?php echo ($orderby=="investor")?$ordertype:""; ?>" id="investor">Investor</th>
                                <th style="width: 10%;" class="header <?php echo ($orderby=="dates")?$ordertype:""; ?>" id="dates">Date</th>
                                 <th style="width: 10%;" class="header <?php echo ($orderby=="Exit_Status")?$ordertype:""; ?>" id="Exit_Status">Exit Status</th>
                                <th style="width: 10%;" class="header asc <?php echo ($orderby=="amount")?$ordertype:""; ?>" id="amount">Amount (US$M)</th>
                                </tr></thead>
                              <tbody id="movies">
                                <?php
                               
                                if ($company_cnt>0)
                                  {
                                        $hidecount=0;

                                         mysql_data_seek($companyrs,0);
                                   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                        {
                                                $amtTobeDeductedforAggHide=0;
                                                $prd=$myrow["dealperiod"];


                                                if($myrow["SPV"]==1)
                                                {
                                                        $openBracket="(";
                                                        $closeBracket=")";
                                                }
                                                else
                                                {
                                                        $openBracket="";
                                                        $closeBracket="";
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
                                                        $hideamount=$myrow["amount"];
                                                }
                                                if($myrow["REType"]!="")
                                                {
                                                        $showindsec=$myrow["REType"];
                                                }
                                                else
                                                {
                                                        $showindsec="&nbsp;";
                                                }

                                                $companyName=trim($myrow["companyname"]);
                                                $companyName=strtolower($companyName);
                                                $compResult=substr_count($companyName,$searchString);
                                                $compResult1=substr_count($companyName,$searchString1);
                                                if($myrow["AggHide"]==1)
                                                {

                                                        $openaggBracket="{";
                                                        $closeaggBracket="}";

                                                        $amtTobeDeductedforAggHide=$myrow["amount"];
                                                        $NoofDealsCntTobeDeducted=1;
                                                }
                                                else
                                                {
                                                       $openaggBracket="";
                                                        $closeaggBracket="";
                                                        $amtTobeDeductedforAggHide=0;
                                                        $NoofDealsCntTobeDeducted=0;
                                                }
                                                
                                                
                                                
                                                if($myrow["Exit_Status"]==1){
                                                    $exitstatus_name = 'Unexited';
                                                }
                                                else if($myrow["Exit_Status"]==2){
                                                     $exitstatus_name = 'Partially Exited';
                                                }
                                                else if($myrow["Exit_Status"]==3){
                                                     $exitstatus_name = 'Fully Exited';
                                                }
                                                else{
                                                    $exitstatus_name = '--';
                                                }
                                
                                
                                                /*$invsql = "SELECT inv.investor FROM REinvestors as inv, REinvestments_investors as reinv where inv.InvestorId=reinv.InvestorId and reinv.PEId=".$myrow["PEId"];
                                               
                                                $result = mysql_query($invsql) or die(mysql_error());
                                                $displayinvestor = mysql_fetch_object($result)->investor;*/
                                                ?>
                                        <tr class="details_link" valueId="<?php echo $myrow["PEId"]."/".$value."/";?>">
						<?php
								if(($compResult==0) && ($compResult1==0))
								{
                                                                    //echo $openaggBracket."dddddddddddddddddd".$closeaggBracket;
						?>
                                                                            <td style="width: 1090px;"><?php echo $openBracket;?><?php echo $openaggBracket; ?><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"]."/".$value."/";?>" id="dealid<?php echo $myrow["PEId"];?>" ><?php echo trim($myrow["companyname"]);?>  </a> <?php echo $closeaggBracket; ?><?php echo $closeBracket; ?></td>
						<?php
								}
								else
								{
						?>
								<td style="width: 1090px;"><?php echo ucfirst("$searchString");?></td>
						<?php
								}
						?>

                                                                <td style="width: 245px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"]."/".$value."/";?>"><?php echo $myrow["dealcity"]; ?></a></td>
                                                                <td style="width: 540px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"]."/".$value."/";?>"><?php echo $myrow["Investor"]; ?></a></td>
                                                                <td style="width: 210px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"]."/".$value."/";?>"><?php echo $prd; ?></a></td>
                                                                
                                                                <td style="width: 182px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"]."/".$value."/";?>"><?php echo $exitstatus_name; ?></a></td>
                                                                <td style="width: 182px;"><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"]."/".$value."/";?>"><?php echo $hideamount; ?>&nbsp;</a></td>
						
                                        </tr>
							<?php

							}
						}
                                                /*if($hidecount==1)
                                                {
                                                        $totalAmount="--";
                                                }*/
						?>
                        </tbody>
                  </table>
                       
                </div>			
                           
                
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
                     <div class="pagination-section"><input type="text" name = "paginaitoninput" id = "paginationinput" class = "paginationtextbox" placeholder = "P.no" onkeyup = "paginationfun(this.value)">
            <button class = "jp-page1 button pagevalue" name="pagination"  id= "pagination" type="submit" onclick = "validpagination()">Go</button></div>
            </center>

            <?php 
            }else{
                echo '<div style="margin-left:30px;margin-top:20px;"><h3>No Data Found</h3></div>';
            }
            
        } 
    ?>
						                 
           <?php
           $firstlogin = mysql_num_rows( mysql_query("SELECT * FROM RElogin_members WHERE EmailId='$emailid' AND tour=0 "));
           
           $exportToExcel=0;
			 /*$TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";*/
                         $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,RElogin_members as dm where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
                         
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$studentOption=$trialrow["Student"];
				}
			}
                        $totalAmount=round($totalAmount, 0);
			$totalAmount=number_format($totalAmount);
                        
                        if($firstlogin==1 || $exportToExcel==0) { $tourautostart='ON'; }
                        
                        
                if($studentOption==1)
                {
                 ?>
                    <script type="text/javascript" >
                           $("#show-total-deal").html('<h2> Total No. of Deals  <?php echo $totalInv; ?></h2>');
                           $("#show-total-amount").html('<h2>Announced Value(US$ M) <?php 
                               if($totalAmount >0)
                               {
                                    echo $totalAmount;
                               }
                               else
                               {
                                   echo "--";
                               } ?>  across  <?php echo $acrossDealsCnt; ?> deals; </h2>');
                    </script>
                    <?php
                    if($exportToExcel==1)
                    {
                    ?>
                        <span style="float:right;margin-right: 20px;" class="one">
                        <input class ="export" type="button"  value="Export" name="showdeals">
                        </span>
                              <div class="title-links" id="exportbtn"></div>
                        <script type="text/javascript">
                              $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                        </script>
                    <?php
                    }
		}
		else
		{
                    if($exportToExcel==1)
                    {
                    ?>
                             <script type="text/javascript" >
                                $("#show-total-deal").html('<h2> Total No. of Deals  <?php echo $totalInv; ?></h2>');
                                $("#show-total-amount").html('<h2>Announced Value(US$ M) <?php
                                    if($totalAmount >0)
                                    {
                                        echo $totalAmount;
                                    }
                                    else
                                    {
                                        echo "--";
                                    } ?>  across  <?php echo $acrossDealsCnt; ?> deals; </h2>');
                            </script>
                           
                    <?php
                    }
                    else
                    {
                    ?>
                            <script type="text/javascript" >
                                $("#show-total-deal").html('<h2> Total No. of Deals XXX</h2>');
                                $("#show-total-amount").html('<h2>Announced Value(US$ M) YYY  across ZZZ deals; </h2>');
                            </script>
                            <div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
                    <?php
                    }
                            if(($totalInv>0) &&  ($exportToExcel==1))
                            {
                            ?>
                                    <span style="float:right;margin-right: 20px;" class="one">
                                    <input class ="export" type="button"  id="expshowdealsbtn" value="Export" name="showdeals">
                                    </span>
                                    <script type="text/javascript">
					$('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                                    </script>
                                    
                            <?php
                            }
                            elseif(($totalInv>0) && ($exportToExcel==0))
                            { $tourautostart='ON';													
                            ?>
                                     <div>
                                    <span>
                                    <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing PE investments.  </p>
                                    <span style="float:right;margin-right: 20px;" class="one">
                                         <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                                    <a class ="export" target="_blank" href="../">Sample Export</a>
                                    </span>
                                    
                                    <script type="text/javascript">
						$('#exportbtn').html('<a class="export"  href="../xls/Sample_Sheet_Investments-RE.xls">Export Sample</a>');
                                                
             
                                    </script>
                                    
                                    
                                    </span>
            					</div>
                    <?php
                            }
              }
    ?>
<div class="overview-cnt mt-trend-tab">
        
                       <div class="showhide-link" id="trendnav" style="z-index: 100000"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? '' : ''; ?>" rel="#slidingTable" id='ldtrend'><i></i>Trend View</a></div>
                            <div  id="slidingTable" style="display: none;overflow:hidden;">
                               <?php
                                 include_once("trendviewre.php");
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
                                        <td width="100%" class="profile-view-left" colspan="2">
                                        <div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
                                        </td>
                                    </tr> 
                                    <?php
                                    }
                                    ?>
                                    
                                    <tr>
                                     <td class="profile-view-left" colspan="2">
                                         <div class="showhide-link link-expand-table">
                                            <a href="#" class="show_hide" rel="#slidingDataTable">View Table</a>
                                         </div><br>
                                         <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;">
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
</td>

</tr>
</table>
 
</div>
</form>
            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $totalInv; ?>">
            <form name="pelisting" id="pelisting"  method="post" action="exportreinvdeals.php">
                 <?php if($_POST) { 
                   
                     foreach($industry as $indid){ ?>
                         <input type="hidden" name="txthideindustryid[]" value=<?php echo $indid; ?> >
                     <?php }
                     foreach($stageval as $stageid){ ?>
                         <input type="hidden" name="txthidestageid[]" value=<?php echo $stageid; ?> >
                     <?php }
                     ?>
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
                        <input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo ($industryvalue)?$industryvalue:""; ?> >
                        <input type="hidden" name="txthideSPVCompany" value=<?php echo $entityProject; ?> >
			<input type="hidden" name="txthideSPVCompanyValue" value=<?php echo $entityProjectvalue; ?> >
                        <input type="hidden" name="txthidestage" value="<?php echo $stagevaluetext; ?>" >
			<input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
			<input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
                        <input type="hidden" name="txthidecomptype" value=<?php echo $companyType; ?> >
			<input type="hidden" name="txthiderange" value=<?php echo $startRangeValue; ?>-<?php echo $endRangeValueDisplay-0.01; ?> >
			<input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?>>
			<input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValueDisplay-0.01; ?> >
			<input type="hidden" name="txthideregionid" value=<?php echo $regionId; ?> >
                        <input type="hidden" name="txthidecity" value="<?php echo $city; ?>">
			<input type="hidden" name="txthideregionvalue" value=<?php echo $regionvalue; ?> >
                        <input type="hidden" name="txthideexitstatusValue" value=<?php echo $exitstatusValue; ?> >


			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
			<input type="hidden" name="txthideinvestorsearch" value="<?php echo $keywordsearch; ?>" >
			<input type="hidden" name="txthidecompany" value=<?php echo $companysearch; ?> >
			<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
			<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
                        
			<input type="hidden" name="txthideadvisorstring_legal" value=<?php echo $stringToHideAcquirer_legal; ?> >
                        
                        <input type="hidden" name="txthide_sectorsearch" value="<?php echo str_replace("'","",trim($sectorsearch)); ?>" >
                        
                 <?php } else { 
                        
                     $industry=[];
                     $stageval=[];
                     ?> 
                                               
                                               
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
			<input type="hidden" name="txthideindustry" value="">
			<input type="hidden" name="txthideindustryid" value="<?php  $industry; ?>">
			<input type="hidden" name="txthidestage" value="">
			<input type="hidden" name="txthidestageid" value="<?php  $stageval; ?>">
                        <input type="hidden" name="txthidecomptype" value="--">
                        <input type="hidden" name="txthidedebt_equity" value="--">
                        <input type="hidden" name="txthideSPVCompany" value="--" >
			<input type="hidden" name="txthideSPVCompanyValue" value="" >
			<input type="hidden" name="txthideinvtype" value="">
			<input type="hidden" name="txthideinvtypeid" value="--">
			<input type="hidden" name="txthideregionvalue" value="">
			<input type="hidden" name="txthideregionid" value="--">
                        <input type="hidden" name="txthidecity" value="">

			<input type="hidden" name="txthiderange" value="-----">
			<input type="hidden" name="txthiderangeStartValue" value="--">
			<input type="hidden" name="txthiderangeEndValue" value="--">

                        <input type="hidden" name="txthideexitstatusValue" value="--" >
                        
                        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value="">
			<input type="hidden" name="txthideinvestorsearch" value="" >
			<input type="hidden" name="txthidecompany" value="">
			<input type="hidden" name="txthideadvisor_legal" value="">
			<input type="hidden" name="txthideadvisor_trans" value="">
			<input type="hidden" name="txthidesearchallfield" value="">
                        <input type="hidden" name="txthideadvisorstring_legal" value="" >
                        
                        
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
                   // alert('click'); return false;
                    
                     if(demotour==1)
                        {  showErrorDialog(warmsg); return false; }  
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


                jQuery('#preloading').fadeIn(1000);   
                $.ajax({
                type : 'POST',
                url  : 'ajaxListview_re.php',
                data: {

                        sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                        totalrecords : '<?php echo addslashes($company_cntall); ?>',
                        page: pageno,
                        orderby:orderby,
                        ordertype:ordertype
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
                        var next=parseInt(pageno)+1;
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
			
            /*$('#expshowdeals,.export').click(function(){ 
                hrefval= 'exportreinvdeals.php';
                $("#pelisting").attr("action", hrefval);
                $("#pelisting").submit();
                return false;
            });*/
    
    
     $('#expshowdeals').click(function(){ 
         
         
         
         if(demotour==1)
         { 
             return false;
         }
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });

    $('#expshowdealsbtn').click(function(){ 
        
        if(demotour==1)
         { 
             return false;
         } 
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });
            
    function initExport(){ 
             if(demotour==1)
                { 
                    return false;
                } 
                
            $.ajax({
                url: 'ajxCheckDownload.php',
                dataType: 'json',
                timeout:10000,
                success: function(data){
                    var downloaded = data['recDownloaded'];
                    var exportLimit = data.exportLimit;
                    var currentRec = <?php echo $totalInv; ?>;

                    //alert(currentRec + downloaded);
                    var remLimit = exportLimit-downloaded;

                    if (currentRec < remLimit){
                        hrefval= 'exportreinvdeals.php';
                        $("#pelisting").attr("action", hrefval);
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
    
			
                  
                function resetinput(fieldname)
                {
                  if(demotour==1)
                     { return false; }
                else {                
                     $("#resetfield").val(fieldname);
                  $("#pesearch").submit();
                    return false;
                }
                }
                $(document).on('click', 'tr .details_link', function(){ 
                    idval=$(this).attr("valueId");
                    $("#detailpost").attr("href","<?php echo BASE_URL; ?>re/redealdetails.php?value="+idval).trigger("click");
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
 
 mysql_close();
?>

<?php if($type==1 && $vcflagValue==0){ ?>
    
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
      function drawVisualization(dealdata) {
		
		var data = new google.visualization.DataTable();
		data.addColumn('string','Year');
                data.addColumn('number', 'Total no. of Deals');
		data.addColumn('number', 'Announced no. of Deals');
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
			 	window.location.href = 'index.php?'+query_string;            
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
                                title: 'Total Deals and Announced Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                     
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 0},
                                2: {targetAxisIndex: 1,type : "bars",curveType: "function"}
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
			 tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">Total No. of Deals</th><th style="text-align:center">Announced No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
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
        
    } else if($type==2 && $vcflagValue==0) {  //  print_r($deal);   

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
					 window.location.href = 'index.php?'+query_string;
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
                /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
				 window.location.href = 'index.php?'+query_string;
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
			// tblCont = tblCont + '<tbody>';
			 
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
     }  else if($type == 4 && $vcflagValue==0){
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
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
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
				 <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
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
       
    <?php } else if($type==5 && $vcflagValue==0)  {   ?>
    
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
                                           //console.log(data);
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
			

			var data1 = google.visualization.arrayToDataTable(dataArray);  
			
		var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
              /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
		  
		  var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
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
			  draw(data3, {title:"By Deal"/*,
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
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
			 
          	// tblCont = '<thead>';
			 tblCont = tblCont + '<tr><th style="text-align:center">INVESTOR</th>';
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
			  
			 
			// tblCont = tblCont + '</thead>';
			// tblCont = tblCont + '<tbody>';
			 
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
			// tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
			
		  
		}
		
		</script>
       
    <?php 
     }  else if($type==6 && $vcflagValue==0)  {    
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
		//Grpah 1
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
			

		var data1 = google.visualization.arrayToDataTable(dataArray);  
			
		chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
        function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
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
		
		  var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
			  draw(data3, {title:"No of Deals"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';
			 
          	// tblCont = '<thead>';
			 tblCont = tblCont + '<tr><th style="text-align:center">REGION</th>';
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
			  
			 
			// tblCont = tblCont + '</thead>';
			// tblCont = tblCont + '<tbody>';
			 
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
					flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
			 pintblcnt = pintblcnt + '</table>';
			 //tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
		  
		}
      </script>
       
    <? }
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
            $('.result-select').css({"max-width":'100%'});
        }
        else if (window.innerWidth > 1024 )
        {
            var searchTitleHeight = filtersHeight + tabHeight + alertHeight-30;
            $('.result-select').css({"max-width":'100%'}); 
         }
        else
        {
            var searchTitleHeight = filtersHeight + tabHeight + alertHeight;
            $('.result-select').css({"max-width":'100%'});

        }
            
            
        //$('.result-cnt').width(containerWidth-refineWidth+188);
        var resultcntHeight = $('.result-cnt').height();

        //$('.view-table').css({"margin-top":resultcntHeight});
        $('.expand-table').css({"margin-top":0});
        //$('.view-table').css({"margin-top":window.innerHeight-826});
			 
        $('.btn-slide').click(function(){ 

            $('.result-select').css('width', 'auto');
            $('.alert-note #exportbtn').css('padding', '3px');
            var containerWidth = $('#container').width();  
            var refineWidth = $('#panel').width();      
            var searchkeyWidth = $('.result-rt-cnt').width();
            var searchTitleWidth = $('.result-title').width();
            var searchTitleHeight = $('.result-cnt').height(); 

            $('.result-cnt').width(containerWidth-refineWidth-40)
           // $('.result-select').width(searchTitleWidth-searchkeyWidth-250);
            // if (window.innerWidth > 1700)
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
            if (window.innerWidth > 1700)
            {
                $('.result-select').css({"max-width":'100%'});
            }
            else if (window.innerWidth > 1024 )
            {
                $('.result-select').css({"max-width":'100%'});
             }
            else
            {
                $('.result-select').css({"max-width":'100%'});
            }

            if ($('.left-td-bg').width() < 264) {
                $('.result-cnt').width(containerWidth-refineWidth-40); 

                 var searchTitleHeight = $('.result-cnt').height(); 
                             //$('.view-table').css({"margin-top":searchTitleHeight});
                             $('.expand-table').css({"margin-top":0});
            } else {
                $('.result-cnt').width(containerWidth-refineWidth+188); 
                            //$('.result-select').width(searchTitleWidth-searchkeyWidth);

                 var searchTitleHeight = $('.result-cnt').height(); 	
                             //$('.view-table').css({"margin-top":searchTitleHeight});
                             $('.expand-table').css({"margin-top":0});
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
            //     $('.result-cnt').width(containerWidth-refineWidth+188);  
            // } else {
            //     $('.result-cnt').width(containerWidth-refineWidth-40); 
            // } 
            if (window.innerWidth > 1700)
            {
                $('.result-select').css({"max-width":'100%'});
            }
            else if (window.innerWidth > 1024 )
            {
                $('.result-select').css({"max-width":'100%'});
             }
            else
            {
                $('.result-select').css({"max-width":'100%'});
            }
            if ($('.left-td-bg').width() < 264) {
                $('.result-cnt').width(containerWidth-refineWidth+188);  
            } else {
                $('.result-cnt').width(containerWidth-refineWidth-40); 
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
       
       
         $("a.postlink").live( "click", function() {
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

        $( "#sltindustry" ).on('change', function() {
            $('#searchallfield').val('');
        });
         
                                        
    </script>  
    
    
      <script type="text/javascript" >
     
      
         
         
         
      
      <?php if($tourautostart=='ON'){ ?>
       $(document).ready(function(){
        
         <?php  if(!isset($_SESSION["tourautostart"])) { $_SESSION["tourautostart"]=1; ?>
                hopscotch.startTour(tour, 0); 
        <?php } ?>
            
        });
      <?php } ?>
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
      
      
    $(document).ready(function(){
        
              
        <?php 
        
           if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){
        
         if(isset($_POST["searchpe"]) || ($_POST["month1"]=='1' && $_POST["month2"]=='3' && $_POST["year1"]=='2014' && $_POST["year2"]=='2014') ){?>
                hopscotch.startTour(tour, 4);  
        <?php } 
        else if(isset($_POST["industry"])){?>
                hopscotch.startTour(tour, 3);              
        <?php }           
        
          else {?> 
                    hopscotch.startTour(tour, 0); 
        <?php } ?>
          
                          
            
            //// multi select checkbox hide
            $('.ui-multiselect').attr('id','uimultiselect');    

           $("#uimultiselect, #uimultiselect span").click(function() {
                if(demotour==1)
                        {  showErrorDialog(warmsg); $('.ui-multiselect-menu').hide(); }     
            });
            
            
            
               
     <?php } ?>
    var winwdth = $(window).width();
var width = $('.left-td-bg').width();
var test = (winwdth - width)-50 ;
$(".result-cnt").css("width",test);
          
         
    });
   
   
       function blocktourover()
       {
          if(demotour==1) {
          $('#icon-detailed-view').removeAttr('href');
          $('#icon-grid-view').removeAttr('href');
          $('#icon-detailed-view').attr('href','javascript:');
          $('#icon-grid-view').attr('href','javascript:');
          }
       }
       
       function blocktourout()
       {
          if(demotour==1) {
          $('#icon-detailed-view').removeAttr('href');
          $('#icon-detailed-view').attr('href','redealdetails.php?value=<?php echo $comid?>');
          $('#icon-grid-view').attr('href','reindex.php');
          }
       }
       
       function searchcloseover()
       {
            if(demotour==1) {
                $('#allfilterclear').removeAttr('href');
            }
       }
       function searchcloseout()
       {
            if(demotour==1) {
                $('#allfilterclear').attr('href','reindex.php');
            }
       }
             ///////
             
            $( window ).scroll(function() {
            hopscotch.refreshBubblePosition();
           });
           
          
           
        </script>
        <?php  include("../survey/survey.php"); ?>
        <?php if($tourautostart!='ON' && $popup_search == 0){  //$_SESSION['re_popup_display'] != 'none' ?>
            <script>
			   $(document).ready(function(){
                            $('.popup_close a').click(function(){
                                $(".popup_main").hide();
                                localStorage.removeItem("pageno");
                             });
			   });
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
	    padding: 30px 25px 85px;
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
        position: relative;
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
              <option value="investor">Investor</option>
              <option value="company">Company</option>
              <option value="sector">Sector</option>
              <option value="legal_advisor">Legal Advisor</option>
              <option value="transaction_advisor">Transaction Advisor</option>
         </select>
         <div class="popup_searching">
            <input type="text" name="popup_keyword" id="popup_keyword" value="" placeholder="Enter Keyword" class="popup_text" autocomplete="off"/>
            <input type="hidden" name="advisor_type" id="advisor_type" value="" />
            <div id="search_load" style="  overflow-y: scroll;  max-height: 130px;  background: #fff;display:none;  width: 300px;position: absolute;top: 40px;">
            <span id="com_clearall" title="Clear All" onclick="clear_allsearch();" style="background: rgb(191, 160, 116); position: absolute; top: 29px; right: 30px; padding: 3px; display: block;">(X)</span>
            <div class="auto_keywords">
                <ul class="popup_auto_result"></ul>
           </div>
         </div>
      </div>
      <div class="popup_btn">
             <!--<a href="javascript:void(0)" class="popup_cancel">Cancel</a>
             <a href="javascript:void(0)" class="popup_search">Search</a>-->
             <a href="javascript:void(0)" class="popup_cancel">Cancel</a>
             <input type="button" name="popup_submit" class="popup_search" value="Search" onclick="this.form.submit();" >
      </div>
      </form> 
  </div>
</div>	
</div>	
        <?php //$_SESSION['re_popup_display'] = 'none'; 
        } ?>


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
        });
    </script>

    <style>
        .paginationtextbox{
            width:3%;
            padding: 3px;
        }

        input[type='text']::placeholder
        {   
            text-align: center;      /* for Chrome, Firefox, Opera */
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