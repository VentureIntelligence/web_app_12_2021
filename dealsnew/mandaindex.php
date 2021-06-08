<?php
/*echo '<pre>';
   print_r($_POST);
   echo '</pre>';*/
//other database
    /**$all_keyword_other = trim($_POST['all_keyword_other']);
    $searchallfield_other = $_POST['searchallfield_other'];
    $investorauto_sug_other = $_POST['investorauto_sug_other'];
    $keywordsearch_other = $_POST['keywordsearch_other'];
    $companyauto_other =$_POST['companyauto_other'];
    $companysearch_other =$_POST['companysearch_other'];
    $sectorsearch_other =$_POST['sectorsearch_other'];
    $advisorsearch_legal_other =$_POST['advisorsearch_legal_other'];
    $advisorsearch_trans_other =$_POST['advisorsearch_trans_other'];*/
    $tagandor=$_POST['tagandor'];
    $tagradio=$_POST['tagradio'];
    $invandor = $_POST['invandor'];
    $invradio = $_POST['invradio'];
    $VCFlagValueString = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0-1';
    if($VCFlagValueString == '0-2')
    {
        $popup_search = 0;
    }else{
        $popup_search = 1;
    }
    if ($_POST['popup_select'] == '' && $_POST['popup_keyword'] != '') {
        $searchallfield = trim($_POST['popup_keyword']);
    } elseif ($_POST['popup_select'] == 'exact' && $_POST['popup_keyword'] != '') {
        $searchallfield = trim($_POST['popup_keyword']);
    }
    if($_POST['tagsearch'] != "" || $_POST['tagsearch_auto'] != ""){
        $_POST['keywordsearch'] = "";
        $_POST['searchallfield'] = "";
        $_POST['investorauto_sug'] = "";
        $_POST['companysearch'] = "";
        $_POST['companyauto_sug'] = "";
        $_POST['acquirerauto'] = "";
        $_POST['acquirersearch'] = "";
        $_POST['advisorsearch_legal'] = "";
        $_POST['advisorsearch_legalauto'] = "";
        $_POST['advisorsearch_trans'] = "";
        $_POST['advisorsearch_transauto'] = "";
        $_POST['stage'] = "";
        $_POST['industry'] = "";
        $_POST['sector'] = "";
        $_POST['subsector'] = "";
        $_POST['invType'] = "";
        $_POST['dealtype'] = "";
        $_POST['exitstatus'] = "";
        $_POST['txtmultipleReturnFrom'] = "";$_POST['txtmultipleReturnTo'] = "";
        $_POST['yearafter']="";
        $_POST['yearbefore']="";
        $_POST['invhead'] = "";
    }
    if(isset($_POST['all_keyword_other'])){
        $all_keyword_other = trim($_POST['all_keyword_other']);
    }
    
    if(isset($_POST['searchallfield_other'])){
        $searchallfield_other = $_POST['searchallfield_other'];
    }
    
    if(isset($_POST['investorauto_sug_other'])){
        $investorauto_sug_other = $_POST['investorauto_sug_other'];
    }
    
    if(isset($_POST['keywordsearch_other'])){
        $keywordsearch_other = $_POST['keywordsearch_other'];
    }
    
    if(isset($_POST['companyauto_other'])){
        $companyauto_other =$_POST['companyauto_other'];
    }
    
    if(isset($_POST['companysearch_other'])){
        $companysearch_other =$_POST['companysearch_other'];
    }
    
    if(isset($_POST['sectorsearch_other'])){
        $sectorsearch_other =$_POST['sectorsearch_other'];
    }
    
    if(isset($_POST['sectorsearch_other'])){
        $advisorsearch_legal_other =$_POST['advisorsearch_legal_other'];
    }
    
    if(isset($_POST['sectorsearch_other'])){
        $advisorsearch_trans_other =$_POST['advisorsearch_trans_other'];
    }

    if( isset( $_POST[ 'period_flag' ] ) ) {
        $period_flag = $_POST[ 'period_flag' ];
    } else {
        $period_flag = 1;
    }
    
    if(isset($all_keyword_other) && $all_keyword_other !=''){
        
        if(isset($keywordsearch_other) && $keywordsearch_other !=''){
            
            $ex_keywordsearch_other = explode(',', $keywordsearch_other);
            $ex_investorauto_sug_other = explode(',', $investorauto_sug_other);//echo $all_keyword_other;print_r($ex_keywordsearch_other);
            if(!in_array($all_keyword_other, $ex_keywordsearch_other)){
                
                if(!in_array($all_keyword_other, $ex_investorauto_sug_other)){ 
                    
                    $_POST['keywordsearch_other'] ='';
                    $_POST['investorauto_sug_other'] = '';
                }else{ 
                    
                    $key = array_search($all_keyword_other, $ex_keywordsearch_other);
                    $_POST['keywordsearch_other'] =$ex_investorauto_sug_other[$key];
                    $_POST['investorauto_sug_other'] = $all_keyword_other;   
                    $incubation_from = "yes";
                }
            }else{ 
                $key = array_search($all_keyword_other, $ex_keywordsearch_other);
                $_POST['keywordsearch_other'] =$all_keyword_other;
                $_POST['investorauto_sug_other'] = $ex_investorauto_sug_other[$key]; 
            }
        }
        else if(isset($companyauto_other) && $companyauto_other !=''){
            
            $ex_companyauto_other = explode(',', $companyauto_other);
            $ex_companysearch_other = explode(',', $companysearch_other);
            if(!in_array($all_keyword_other, $ex_companyauto_other)){
                
                $_POST['companyauto_other'] ='';
                $_POST['companysearch_other'] = '';
            }else{
                
                $key = array_search($all_keyword_other, $ex_companyauto_other);
                $_POST['companyauto_other'] =$all_keyword_other;
                $_POST['companysearch_other'] = $ex_companysearch_other[$key]; 
            }
        }
        else if(isset($sectorsearch_other) && $sectorsearch_other !=''){
            
            $ex_sectorsearch_other = explode(',', $sectorsearch_other);
            if(!in_array($all_keyword_other, $ex_sectorsearch_other)){
                $_POST['sectorsearch_other'] = '';
            }else{
                $_POST['sectorsearch_other'] =$all_keyword_other;
            }
        }
        else if(isset($advisorsearch_legal_other) && $advisorsearch_legal_other !=''){
            
            if($all_keyword_other != $advisorsearch_legal_other){
                
                $_POST['advisorsearch_legal_other'] = '';
            }else{
                
                $_POST['advisorsearch_legal_other'] =$all_keyword_other;
            }
        }
        else if(isset($advisorsearch_trans_other) && $advisorsearch_trans_other !=''){
            
            if($all_keyword_other != $advisorsearch_trans_other){
                
                $_POST['advisorsearch_trans_other'] = '';
            }else{
                
                $_POST['advisorsearch_trans_other'] =$all_keyword_other;
            }
        }
        else if(isset($searchallfield_other) && $searchallfield_other !=''){
            
            $ex_searchallfield_other = explode(',', $searchallfield_other);
        }
    }

//====================junaid============================================================
    
    if( isset( $_POST[ 'pe_checkbox' ] ) && !empty( $_POST[ 'pe_checkbox' ] ) ) {
        $pe_checkbox = explode( ',', $_POST[ 'pe_checkbox' ] );
        
        if(count($pe_checkbox)<= 0 && !empty($_POST[ 'uncheckRows' ])){
            
            $pe_checkbox = explode( ',', $_POST[ 'uncheckRows' ] );
        }
    } else {
        $pe_checkbox = '';
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
    
    //=====================================================================================
    
    if( isset( $_POST[ 'pe_amount' ] ) && !empty( $_POST[ 'pe_amount' ] ) ) {
        $pe_amount = $_POST[ 'pe_amount' ];
    }
    if( isset( $_POST[ 'pe_company' ] ) ) {
        $pe_company = $_POST[ 'pe_company' ];
        $peEnableFlag = true;
    }

   //====================jagadeesh rework===================================================
    
    if( isset( $_POST[ 'pe_hide_companies' ] ) ) {
        $pe_hide_companies = explode( ',', $_POST[ 'pe_hide_companies' ] );
        $peHideFlagCh = true;
    }

    //=======================================================================================
    $drilldownflag=0;
    $companyId=632270771;
    $companyIdDel=1718772497;
    $companyIdSGR=390958295;
    $companyIdVA=38248720;
    $companyIdGlobal=730002984;

    $compId=0;
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    
      
   // $VCFlagValueString = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0-1';
    
    // echo '<h1 style="color:#000;">'.$VCFlagValueString.'</h1>';
    
    
    if($VCFlagValueString == '0-1')
    {
        $videalPageName="PMS";
        $defvalue=30;
    }
    else if($VCFlagValueString == '0-0')
    {
         $videalPageName="PEMa";
         $defvalue=31;
    }
    else if($VCFlagValueString == '1-0')
    {
         $videalPageName="VCMa";
         $defvalue=32;
    }
    else if($VCFlagValueString == '1-1')
    {
         $videalPageName="VCPMS";
         $defvalue=33;
    }
    else if($VCFlagValueString == '0-2')
    {
        $videalPageName="MAPM";
        $defvalue=38;
    }
    
    include ('checklogin.php');
    $notable=false;
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
    $VCFlagValue_exit = explode("-", $VCFlagValueString);
    $vcflagValue=$VCFlagValue_exit[0];
    //$hide_pms=$VCFlagValue_exit[1];
    $flagvalue=$VCFlagValueString;
    $VCFlagValue=$VCFlagValue_exit[0];
    $hide_pms=$VCFlagValue_exit[1];
    if($VCFlagValue==0)
    {
        $addVCFlagqry = "";
        $pagetitle="PE Exits - M&A -> Search";
        $companyFlag=5;
    }
    elseif($VCFlagValue==1)
    {
        $addVCFlagqry = " and VCFlag=1";
        $pagetitle="VC Exits - M&A -> Search";
        $companyFlag=6;
    }
    
    if($hide_pms==1)
    {
        $pagetitle="Public Market Sales -> Search";
    }
                
    $addDelind="";
      /* the following till $_POST is added for Del company to show only BFSI & Education industry */
    $GetCompId="select dm.DCompId,dc.DCompId from dealcompanies as dc,dealmembers as dm
    where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";

    if($trialrs=mysql_query($GetCompId))
    {
        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
        {
            $compId=$trialrow["DCompId"];
        }
    }
    
    if($compId==$companyId){ 
        
        $hideIndustry = " and display_in_page=1 "; 
    }
    elseif($compId==$companyIdDel){
        
        $hideIndustry = " and display_in_page=2 ";
    }
    elseif($compId==$companyIdSGR){
        
        $hideIndustry = " and (industryid=3 or industryid=24) ";
    }
    elseif($compId==$companyIdVA){
        
        $hideIndustry = " and (industryid=1 or industryid=3) ";
    }
    else if($compId==$companyIdGlobal){
        
        $hideIndustry = " and (industryid=24) ";
    }
    else{
        $hideIndustry="";     
    }
    
    if($VCFlagValueString == '0-0' || $VCFlagValueString == '0-1' || $VCFlagValueString == '0-2')
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
    }else if($VCFlagValueString == '1-0' || $VCFlagValueString == '1-1'){
        
        if($compId==$companyIdGlobal)
        {
          $addDelind = " and (pec.industry=24)";
        }
    }
    
    $getyear = $_REQUEST['y'];
    $getindus = $_REQUEST['i'];
    $getstage = $_REQUEST['s'];
    $getinv = $_REQUEST['inv'];
    $getreg = $_REQUEST['reg'];
    $getrg = $_REQUEST['rg'];
    //echo print_r($_POST);
    $resetfield=$_POST['resetfield'];
                
    if (isset($_POST['popup_select'])) {
        $month1 = 01;
        $year1 = 1998;
        $month2 = date('n');
        $year2 = date('Y');
        $fixstart = $year1;
        $startyear = $fixstart . "-" . $month1 . "-01";
        $fixend = $year2;
        $endyear = $fixend . "-" . $month2 . "-31";
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET')
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
            $month1= date('n');
            $year1 = date('Y', strtotime(date('Y')." -1  Year"));
            $month2= date('n');
            $year2 = date('Y');
            $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=date("Y");
            $endyear = date("Y-m-d");
        }  
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        if($resetfield=="period")
        {
            $month1= date('n'); 
            $year1 =  date('Y', strtotime(date('Y')." -1  Year"));
            $month2= date('n');
            $year2 = date('Y');
            $_POST['month1']="";
            $_POST['year1']="";
            $_POST['month2']="";
            $_POST['year2']="";
        }
        else if(trim($_POST['searchallfield'])!="" || trim($_POST['investorauto_sug'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['acquirersearch'])!="" || trim($_POST['advisorsearch_legal'])!="" || trim($_POST['advisorsearch_trans'])!="" ){
          //   if(trim($_POST['searchallfield'])!=""){
        //  echo "<h1> Prabhakaran"." </h1><br>"; exit;
            if((!isset($_POST['month1'])) && (!isset($_POST['year1'])) && (!isset($_POST['month2'])) && (!isset($_POST['year2']))){
               
                $month1=01; 
                $year1 = 1998;
                $month2= date('n');
                $year2 = date('Y');         
            }else if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                $month1=01; 
                $year1 = 1998;
                $month2= date('n');
                $year2 = date('Y');
            }else{
                
                $month1=(isset($_POST['month1']) || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                $year1 = (isset($_POST['year1']) || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                $month2=(isset($_POST['month2']) || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                $year2 = (isset($_POST['year2']) || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
             //   }
//                if(trim($_POST['investorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['acquirersearch'])!="" || trim($_POST['advisorsearch_legal'])!="" || trim($_POST['advisorsearch_trans'])!=""){
//                    $month1=01; 
//                    $year1 = 1998;
//                    $month2= date('n');
//                    $year2 = date('Y');
//                }
        }
        elseif (($resetfield=="searchallfield")||($resetfield=="investorsearch")||($resetfield=="companysearch")||($resetfield=="acquirersearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
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
        } elseif( trim($_POST['companyauto_sug'])!="" || trim( $_POST[ 'investorauto_sug' ] != '' ) ) {
            if(($_POST['month1']==date('n')) && $_POST['year1'] == date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                    if( ($_POST['searchallfield']  && $period_flag == 2 ) ) {
                        $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                    } else {
                        $month1=01; 
                        $year1 = 1998;
                        $month2= date('n');
                        $year2 = date('Y');
                    }
            } else {
                $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
        } elseif ( (count($_POST['industry']) > 0) || (count($_POST['dealtype']) > 0)  || ($_POST['invType']!="--") || ($_POST['exitstatus']!="--")
                    || ($_POST['txtmultipleReturnFrom']!="") || ($_POST['txtmultipleReturnTo']!="" ) || $_POST['tagsearch']!='' || $_POST['tagsearch_auto']!='' || $_POST['searchTagsField'] !='')
        {
            
            if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
               
                if($period_flag == 2){
                  
                    $month1 = $_POST['month1'];
                    $year1 = $_POST['year1'];
                } else {
                   
                    $month1=01;
                    $year1 = 1998;
                }
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
           
            $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
            $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] :  date('Y', strtotime(date('Y')." -1  Year"));
            $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
            $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
        }

        $fixstart=$year1;
        $startyear =  $fixstart."-".$month1."-01";
        $fixend=$year2;
        $endyear =  $fixend."-".$month2."-01";
            
    }
        
    if($getyear !='')
    {
        $getdt1 = $getyear.'-01-01';
        $getdt2 = $getyear.'-12-31';
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
    if($vcflagValue==1)
    {
        $addedflagQry = " and VCFlag=1 ";
        $searchTitle = "List of VC Exits - M&A";
        $searchAggTitle = "Aggregate Data - VC Exits - M&A";
    }
    else
    {
        $addedflagQry = "";
        $searchTitle = "List of PE Exits - M&A";
        $searchAggTitle = "Aggregate Data - PE Exits - M&A";
    }

    if($hide_pms==0)
    {   
        $var_hideforexit=0;
        $samplexls="../xls/sample-exits-via-m&a.xls";
    }
    elseif($hide_pms==1)
    {   $var_hideforexit=1;
        $searchTitle = "List of Public Market Sales - Exits";
        $samplexls="../xls/sample-exits-via-m&a(publicmarketsales).xls";
    }
    //Merge view - to set condition for hide_for_exit 
    elseif($hide_pms==2)
    {   $var_hideforexit='0,1';
        $searchTitle = "List of M&A and Public Market Sales - Exits";
        $samplexls="../xls/sample-exits-via-m&a(publicmarketsales).xls";
    }
    
    
    //$addedhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=".$var_hideforexit;
    
    //Merge view - to set hide for hide_for_exit 
    $addedhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit in (".$var_hideforexit.")";
    
    //echo "<br>1 --". $addhide_pms_qry;
    $buttonClicked=$_POST['hiddenbutton'];
                                            //echo "<br>--" .$buttonClicked;
                                            //$fetchRecords=true;
    $aggsql="";
    $totalDisplay="";
    $resetfield=$_POST['resetfield'];

    if($resetfield=="searchallfield")
    { 
        $_POST['searchallfield']="";
        $searchallfield="";
    }
    else 
    {
        if (isset($_POST['searchallfield']) && trim($_POST['searchallfield']) != '') {
            $searchallfield = trim($_POST['searchallfield']);
        } else if ($_POST['popup_select'] == '' && $_POST['popup_keyword'] != '') {
            $searchallfield = trim($_POST['popup_keyword']);
        }
        //$searchallfield=trim($_POST['searchallfield']);
        if($searchallfield != "")
        {
            /*$_POST['investorsearch'] = "";  $_REQUEST['investorauto']="";
            $_POST['acquirersearch'] = "";  $_REQUEST['acquirerauto']=""; 
            $_POST['companysearch'] = "";   $_REQUEST['companyauto']="";
            $_POST['sectorsearch'] = "";    $_REQUEST['sectorauto']="";
            $_POST['advisorsearch_legal'] = "";$_POST['tagsearch']="";
            $_POST['advisorsearch_trans'] = "";*/
            
            $_POST['investorsearch'] = "";  
            $_POST['investorauto']="";
            $_POST['keywordsearch_sug']="";
            $_POST['investorauto_sug']="";
            $_POST['acquirersearch'] = "";  
            $_POST['acquirerauto']=""; 
            $_POST['companysearch'] = ""; 
            $_POST['companyauto_sug']="";
            $_POST['sectorsearch_multiple'] = "";
            $_POST['sectorauto'] = "";
            $_POST['advisorsearch_legal'] = ""; 
            $_POST['advisorsearch_legalauto'] = "";
            $_POST['advisorsearch_trans'] = ""; 
            $_POST['advisorsearch_transauto'] = "";
            $_POST['tagsearch']="";
            $_POST['tagsearch_auto']="";
            if($VCFlagValueString == '0-2')
            {
                $_POST['InType']="";
            }
        }
    }
    $searchallfieldhidden = preg_replace('/\s+/', '_', trim($searchallfield));

    if($resetfield=="acquirersearch")
    { 
    $_POST['acquirersearch']="";
    $acquirersearch="";
     $acquirerauto='';

    }
    else 
    {
    $acquirersearch=trim($_POST['acquirersearch']);
        if($acquirersearch!=''){
            $searchallfield='';
        }
             $acquirerauto=$_REQUEST['acquirerauto'];
    }

    if($resetfield=="companysearch")
    { 
        
        $arrayval=explode(",",$_POST['companyauto_sug']);
        $pos = array_search($_POST['resetfieldid'], $arrayval);
        $companysearch = $arrayval;
        unset($companysearch[$pos]);
        $companysearch=implode(",",$companysearch);
        $_POST['companysearch'] = $companysearch;
       
     /*$_POST['companysearch']="";
     $companysearch="";
      $companyauto='';*/
       $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";
        $sql_company_Exe=mysql_query($sql_company);
        $company_filter="";
        $response =array();
        $i = 0;
        While($myrow = mysql_fetch_array($sql_company_Exe,MYSQL_BOTH)){

            $response[$i]['id']= $myrow['id'];
            $response[$i]['name']= $myrow['name'];
            if($i!=0){

                $company_filter.=",";
                $company_id .=",";
            }
                $company_filter.=$myrow['name'];
                $company_id .= $myrow['id'];
            $i++;
        }

        if($response != '')
        {
            $companysug_response= json_encode($response);
        }
        else{
            $companysug_response= 'null';
        }

        if($companysearch!=''){
            
            $searchallfield='';
        }
    }
    else 
    {
       // print_r($_POST['companyauto_sug']);
       if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'company') {
        //$companysearch=trim($_POST['popup_keyword']);
        $companyauto = $companysearch = trim(implode(',', $_POST['search_multi']));
        }
        else if(isset($_POST['companyauto_other']) && $_POST['companyauto_other'] !=''){
            
            $companyauto=$_POST['companyauto_other'];
            $companysearch=trim($_POST['companysearch_other']);
            $companysearchhidden= preg_replace('/\s+/', '_', $companysearch);
      //  $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
            $month1=01; 
            $year1 = 1998;
            $month2= date('n');
            $year2 = date('Y');
            $dt1 = $startyear =  $year1."-".$month1."-01";
        }else if($_POST['searchallfieldHide'] =='remove' || $_POST['searchallfieldHide'] !='content_exit'){
            
            if(isset($_POST['companyauto_sug'])){
                
                $companyauto = $companysearch=trim($_POST['companyauto_sug']);
                $companysearchhidden=trim($_POST['companyauto_sug']);
            }else{
                
                $companyauto = $companysearch=$companysearchhidden='';
            }
        } else if($_POST['searchallfieldHide'] =='' && isset($_POST['companyauto_sug'])){
            
            $companyauto = $companysearch=trim($_POST['companyauto_sug']);
            $companysearchhidden=trim($_POST['companyauto_sug']);
        }/*else{
            $companysearch=trim($_POST['companysearch']);
            $companyauto=$_POST['companyauto'];
        }*/
        // if($resetfield=="tagsearch")
        // { 
        //     $_POST['tagsearch']="";
        //     $tagsearch="";
        // }
        // elseif($_POST['tagsearch']  && $_POST['tagsearch'] !=''){
            
        //     $tagsearch="tag:".trim($_POST['tagsearch']);
        // } 
         $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";
        $sql_company_Exe=mysql_query($sql_company);
        $company_filter="";
        $response =array();
        $i = 0;
        While($myrow = mysql_fetch_array($sql_company_Exe,MYSQL_BOTH)){

            $response[$i]['id']= $myrow['id'];
            $response[$i]['name']= $myrow['name'];
            if($i!=0){

                $company_filter.=",";
                $company_id .=",";
            }
                $company_filter.=$myrow['name'];
                $company_id .= $myrow['id'];
            $i++;
        }

        if($response != '')
        {
            $companysug_response= json_encode($response);
        }
        else{
            $companysug_response= 'null';
        }

        if($companysearch!=''){
            
            $searchallfield='';
        }
    }
/*Year Founded*/
        if($resetfield=="yearfounded")
        { 
            $_POST['yearafter']="";
            $_POST['yearbefore']="";
            $yearafter="";
            $yearbefore="";
           
        }
        else 
        {
            $yearafter=trim($_POST['yearafter']);
            $yearbefore=trim($_POST['yearbefore']);
            if( $yearafter !='' || $yearbefore !=''){
                $searchallfield='';
            }

        }

        if($resetfield=="tagsearch"){
             $arrayval=explode(",",$_POST['tagsearch']);
            $pos = array_search($_POST['resetfieldid'], $arrayval);
            $tagsearch = $arrayval;
            unset($tagsearch[$pos]);
            $tagsearch = implode(",",$tagsearch);
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
            // $_POST['tagsearch']="";
            // $_POST['tagsearch_auto'] = "";
            // $tagsearch = "";
            // $tagandor=0;
           
        } else if($_POST['tagsearch_auto']  && $_POST['tagsearch_auto'] !='' || $_POST['tagsearch'] != '') {
            
            //$tagsearchauto = $_POST['tagsearch'];
            if($_POST['tagsearch'] != ''){
                if($_POST['tagsearch_auto'] == ''){
                    $tagsearch = $_POST['tagsearch'];
                } else {
                    if($_POST['tagsearch'] != $_POST['tagsearch_auto']){
                                $tagsearch = $_POST['tagsearch']. "," .$_POST['tagsearch_auto'];
                            } else {
                                $tagsearch = $_POST['tagsearch'];
                            }
                }
                
            } else {
                $tagsearch = $_POST['tagsearch_auto'];
            }
            
            $tagsearcharray = explode(',',$tagsearch);
            $response =array(); 
            $tag_filter="";
            $i = 0;

            foreach ($tagsearcharray as $tagsearchnames){ 
                $response[$i]['name']= $tagsearchnames;
                $response[$i]['id']= $tagsearchnames;
                $i++;
            } 

            if($response != '')
            {
                $tag_response = json_encode($response);
            }
            else{
                $tag_response = 'null';
            }
        }else if (isset($_POST['searchTagsField']) && trim($_POST['searchTagsField']) != '') {
    $tagsearch = trim($_POST['searchTagsField']);
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
} else if ($_POST['popup_select'] == 'tags' && $_POST['popup_keyword'] != '') {
    $tagsearch = trim($_POST['popup_keyword']);
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
        
       
    
                
    if($companysearch!=="")
    {
        $splitStringCompany=explode(" ", trim($companysearch));
        $splitString1Company=$splitStringCompany[0];
        $splitString2Company=$splitStringCompany[1];
        $stringToHideCompany=$splitString1Company. "+" .$splitString2Company;
    }
    
    if($resetfield=="sectorsearch")
    { 
        $_POST['sectorsearch']="";
        $sectorsearch="";
    }
    else 
    {
        if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'sector') {
            $sectorsearch = trim($_POST['popup_keyword']);
            $response = array();
        }else if(isset($_POST['sectorsearch_other']) && $_POST['sectorsearch_other'] !=''){
            
            $sectorsearch=$_POST['sectorsearch_other'];
            $sectorsearchhidden=preg_replace('/\s+/', '_', $sectorsearch);
            $month1=01; 
            $year1 = 1998;
            $month2= date('n');
            $year2 = date('Y');
            $dt1 = $startyear =  $year1."-".$month1."-01";
        }else{
            $sectorsearch=stripslashes(trim($_POST['sectorsearch']));
        }
        
        if($sectorsearch!=''){
            
            $searchallfield='';
        }
    }
    $sectorsearchhidden=preg_replace('/\s+/', '_', $sectorsearch);

    if($resetfield=="investorsearch")
    { 
        // $_POST['investorauto_sug']="";
        // $investorsearch="";
        // $investorauto='';
        $investorarray = explode(',', $_POST['investorauto_sug']);
        $pos = array_search($_POST['resetfieldid'], $investorarray);
        $keyword = $investorarray;
        unset($keyword[$pos]);
        $keyword = implode(',', $keyword);
        $_POST['investorauto_sug']=$keyword;
        $investorsearch=$keyword;
        $investorauto=$keyword;

        $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($investorsearch) order by InvestorId";

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
                $invester_filter_id .= ",";
            }
            $invester_filter.=$myrow['name'];
            $invester_filter_id .= $myrow['id'];
            $i++;

         }

        $investorsug_response= json_encode($response);
    }
    else 
    {
        if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'investor') {
            $investorauto = $investorsearch = trim(implode(',', $_POST['search_multi']));
            $keywordhidden = trim($_POST['popup_keyword']);
        } else if(isset($_POST['investorauto_sug_other']) && $_POST['investorauto_sug_other'] !=''){

           $investorauto=$_POST['investorauto_sug_other'];
           $investorsearch = $keyword=trim($_POST['investorauto_sug_other']);
           $keywordhidden=preg_replace('/\s+/', '_', $keyword);
        //  $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
           $month1=01; 
           $year1 = 1998;
           $month2= date('n');
           $year2 = date('Y');
           $dt1 = $startyear =  $year1."-".$month1."-01";
        }else{
           $investorsearch=trim($_POST['investorauto_sug']);
           $investorsearchhidden=trim($_POST['investorauto_sug']);
        }
        
        if($investorsearch!=''){
            $searchallfield='';
        }
        $investorauto = $_POST['investorauto_sug'];
        $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($investorsearch) order by InvestorId";

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
                $invester_filter_id .= ",";
            }
            $invester_filter.=$myrow['name'];
            $invester_filter_id .= $myrow['id'];
            $i++;

         }

        $investorsug_response= json_encode($response);
                
    }
//                if($investorsearch!=="")
//                {
//                    $splitStringInvestor=explode(" ", trim($investorsearch));
//                    $splitString1Investor=$splitStringInvestor[0];
//                    $splitString2Investor=$splitStringInvestor[1];
//                    $stringToHideInvestor=$splitString1Investor. "+" .$splitString2Investor;
//                }

    if($resetfield=="advisorsearch_legal")
    { 
     $_POST['advisorsearch_legal']="";
      $advisorsearchstring_legal="";
    }
    else 
    {
        if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'legal_advisor') {
            $advisorsearchstring_legal_id = trim($_POST['popup_keyword']);
    
            $advisorsql = "select cianame from advisor_cias where cianame='$advisorsearchstring_legal_id'";
            if ($advisorrs = mysql_query($advisorsql)) {
                while ($myrow = mysql_fetch_array($advisorrs, MYSQL_BOTH)) {
                    $legal_filter = $advisorsearchstring_legal = $myrow["cianame"];
                }
            }
        }else if(isset($_POST['advisorsearch_legal_other']) && $_POST['advisorsearch_legal_other'] !=''){
            $advisorsearchstring_legal=$_POST['advisorsearch_legal_other'];
            $month1=01; 
            $year1 = 1998;
            $month2= date('n');
            $year2 = date('Y');
            $dt1 = $startyear =  $year1."-".$month1."-01";
        }else{
            $advisorsearchstring_legal=$_POST['advisorsearch_legal'];
            if($advisorsearchstring_legal!=''){
               $searchallfield='';
            }
        }
    }
    $advisorsearchhidden_legal=preg_replace('/\s+/', '_', $advisorsearchstring_legal);

    if($resetfield=="advisorsearch_trans")
    { 
     $_POST['advisorsearch_trans']="";
      $advisorsearchstring_trans="";
    }
    else 
    {
        if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'transaction_advisor') {
            $advisorsearchstring_trans_id = trim($_POST['popup_keyword']);
    
            $advisorsql = "select cianame from advisor_cias where cianame='$advisorsearchstring_trans_id'";
    
            if ($advisorrs = mysql_query($advisorsql)) {
                while ($myrow = mysql_fetch_array($advisorrs, MYSQL_BOTH)) {
                    $transaction_filter = $advisorsearchstring_trans = $myrow["cianame"];
                }
            }
        }else if(isset($_POST['advisorsearch_trans_other']) && $_POST['advisorsearch_trans_other'] !=''){

            $advisorsearchstring_trans=$_POST['advisorsearch_trans_other'];
            $month1=01; 
            $year1 = 1998;
            $month2= date('n');
            $year2 = date('Y');
            $dt1 = $startyear =  $year1."-".$month1."-01";
        }else{

            $advisorsearchstring_trans=$_POST['advisorsearch_trans'];
            if($advisorsearchstring_trans!=''){
                $searchallfield='';
            }
        }
        $advisorsearchhidden_trans=preg_replace('/\s+/', '_', $advisorsearchstring_trans);
    }
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
    if($resetfield=="industry")
    { 
        //$_POST['industry']=array();
        $pos = array_search($_POST['resetfieldid'], $_POST['industry']);
        $industry = $_POST['industry'];
        unset($industry[$pos]);

        $_POST['filtersector'] = "";$_POST['filtersubsector'] = "";$_POST['sector'] = "";$_POST['subsector'] = "";
         $filtersubsector = '';$filtersector = '';
        //$industry=array();
    }
    else 
    {
        $industry=$_POST['industry'];
        if(count($industry) > 0){
            $searchallfield='';
        }
    }
    if ($resetfield == "sector") {
        $pos = array_search($_POST['resetfieldid'], $_POST['sector']);
        $sector = $_POST['sector'];
        unset($sector[$pos]);
        //$_POST['sector'] = "";
        $_POST['subsector'] = "";
        $_POST['filtersubsector'] = "";
        $filtersubsector = '';
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
       // $_POST['subsector'] = "";
    } else {
        $subsector = $_POST['subsector'];
        if ($subsector != '--' && count($subsector) > 0) {
            $searchallfield = '';
        }
    }           
    if($resetfield=="dealtype")
    { 
        $pos = array_search($_POST['resetfieldid'], $_POST['dealtype']);
        $dealtype = $_POST['dealtype'];
        unset($dealtype[$pos]);
        // $_POST['dealtype']=array();
        // $dealtype=array();
    }
    else 
    {
        $dealtype=$_POST['dealtype'];
        if(count($dealtype) > 0 && $dealtype!=''){
               $searchallfield='';
       }
    }
    if ($resetfield == "invhead") {
        $_POST['invhead'] = "";
        $investor_head = "--";
        
    } else {
        $investor_head = $_POST['invhead'];
        if ($investor_head != '--' && $investor_head != '') {
            $searchallfield = '';
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
        if($investorType!='--' && $investorType!='')
            {
                $searchallfield='';
        }
    }
                
    if($resetfield=="InType")
    { 
        $_POST['InType']="";
        $InType="";
    }
    else 
    {
        $InType=trim($_POST['InType']);
        if($InType!='')
        {
            $searchallfield='';
        }
    }

    if($resetfield=="exitstatus")
    { 
        $_POST['exitstatus']="";
        $exitstatusvalue="";
    }
    else 
    {
        $exitstatusvalue=trim($_POST['exitstatus']);
        if($exitstatusvalue!='--' && $exitstatusvalue!=''){
            $searchallfield='';
        }
    }
    $startRangeValue="--";
    $endRangeValue="--";
                
    if($resetfield=="returnmultiple")
    { 
        $_POST['txtmultipleReturnFrom']="";
        $txtfrm=""; 
        $_POST['txtmultipleReturnTo']="";
        $txtto="";
    }
    else 
    {
        $txtfrm=trim($_POST['txtmultipleReturnFrom']);
        $txtto=trim($_POST['txtmultipleReturnTo']);
                 
        if($txtfrm>0 && $txtto>0){
            $searchallfield='';
        }
    }
    
    $whereind="";
    $wheredealtype="";
    $wheredates="";
    $whererange="";
    $whereReturnMultiple="";
    if($industry !='' && (count($industry) > 0))
    {
        $indusSql = $industryvalue = '';
        foreach($industry as $industrys)
        {
            $indusSql .= " IndustryId=$industrys or ";
        }
        $indusSql = trim($indusSql,' or ');
        $industrysql= "select industry,industryid from industry where $indusSql";

        if ($industryrs = mysql_query($industrysql))
        {
                While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                {
                    $industryvalue.=$myrow["industry"].',';
                    $industryvalueid .= $myrow["industryid"] . ',';
                }
        }
        $industryvalue=  trim($industryvalue,',');
        $industryvalueid = trim($industryvalueid, ',');
        $industry_hide = implode($industry,',');
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
    if(count($dealtype) >0){

        $dealSql = $dealtypevalue = '';
        foreach($dealtype as $dealtypes)
        {
            $dealSql .= " DealTypeId=$dealtypes or ";
        }
        $dealSql = trim($dealSql,' or ');
        $dealtypesql= "select DealType from dealtypes where $dealSql";
    }
    elseif((count($dealtype)==0) && ($hide_pms==1)){

        $dealtypesql= "select DealType from dealtypes where hide_for_exit=".$hide_pms;
    }
    
    //echo "<Br>***** ".$dealtypesql;
    if ($dealtypers = mysql_query($dealtypesql))
    {
            While($myrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
            {
                $dealtypevalue.=$myrow["DealType"].',';
            }
        $dealtypevalue=  trim($dealtypevalue,',');
        $dealtype_hide = implode($dealtype,',');
    }

    //echo "<bR>%%%%%%".$dealtypevalue;
    if($investorType !="--" && $investorType !="")
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
    if(($startRangeValue != "--")&& ($endRangeValue != "--") && ($startRangeValue != "")&& ($endRangeValue != ""))
    {
        $startRangeValue=$startRangeValue;
        $endRangeValue=$endRangeValue-0.01;
    }
    $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
    $splityear1=(substr($year1,2));
    $splityear2=(substr($year2,2));           
                
    if(isset($_POST['searchallfield_other']) && $_POST['searchallfield_other']!=''){

        $searchallfield=$_POST['searchallfield_other'];
        $searchallfieldhidden=preg_replace('/\s+/', '_', $searchallfield);

        $month1=01; 
        $year1 = 1998;
        $month2= date('n');
        $year2 = date('Y');                                           
    }
                        
    if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
    {
        $sdatevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
        $edatevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
        $wheredates1= "";
    }
    $datevalueDisplay1= $sdatevalueDisplay1;
    $datevalueDisplay2= $edatevalueDisplay2;
            
    $aggsql= "select count(pe.MandAId) as totaldeals,sum(pe.DealAmount) as totalamount from manda as pe,industry as i,pecompanies as pec where";
    
    if($_SESSION['PE_industries']!=''){

        $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
    }
                               
                            //if (($acquirersearch == "") && ($companysearch=="") && ($searchallfield=="") && ($investorsearch=="") && ($advisorsearchstring_legal=="")  && ($advisorsearchstring_trans=="")&& ($industry =="--") &&  ($dealtype == "--")  && ($invType == "--")  && ($exitstatusvalue=="--") &&  ($range == "--") && ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--"))
    $orderby=""; $ordertype="";   
    if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
    {
        
        $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
        sector_business as sector_business, pe.DealAmount, i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period,
        (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
        FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,manda_investors as mandainv where DealDate between '" . $getdt1. "' and '" . $getdt2 . "' AND 
        i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID and  mandainv.MandAId=pe.MandAId
        and pec.industry != 15 and pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry. $addDelind. $comp_industry_id_where. " GROUP BY pe.MandAId ";
        $orderby="DealDate";
        $ordertype="desc";
        // echo $companysql;
    }                    
    else if(count($_POST)==0)
    {      

        $dt1 = $year1."-".$month1."-01";
        $dt2 = $year2."-".$month2."-31";

        $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
        sector_business as sector_business, pe.DealAmount,pe.ExitStatus, i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period,
        (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
        FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,manda_investors as mandainv where ";

        if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
        {
            $qryDateTitle ="Period - ";
            $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
        }
        if(($wheredates !== "") )
        {
            $companysql = $companysql . $wheredates ." and ";
            $aggsql = $aggsql . $wheredates ." and ";
            $bool=true;
        }
        $companysql = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
        and  mandainv.MandAId=pe.MandAId
        and pec.industry != 15 and pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry. $addDelind.$comp_industry_id_where. " GROUP BY pe.MandAId ";
        $fetchRecords=true;
        $fetchAggregate==false;
        $orderby="DealDate";
        $ordertype="desc";
        //echo "<br>all records" .$companysql;
        }elseif ($tagsearch != "")
        {
            $iftest=4;
            $yourquery=1;
           // $datevalueDisplay1="";
            $datevalueCheck1="";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";
                
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
            $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
            pe.DealAmount,pec.website, pe.MandAId,pe.Comment,MoreInfor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            FROM manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt
            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
            AND pe.Deleted =0 and pec.industry != 15 " .$addedflagQry . $addedhide_pms_qry . $addDelind.
            " AND ( $tagsval ) $comp_industry_id_where GROUP BY pe.MandAId ";

            $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
            $popup_search=1;
            //  echo "<br>Query for company search";
            //echo "<br> Company search--" .$companysql;
        }
        elseif ($searchallfield != "")
        {
            $iftest=4;
            $yourquery=1;
            //$datevalueDisplay1="";
            $datevalueCheck1="";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";
            
                /*$tagsval = "pec.city LIKE '%$searchallfield%' OR pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%'  or  pe.MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%' or pec.tags like '%$searchallfield%'";*/
                // if($_SESSION['PE_industries']!=''){
            
                //     $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                // }
                $searchExplode = explode(' ', $searchallfield);
                foreach ($searchExplode as $searchFieldExp) {
                    
                    $cityLike .= "pec.city REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
                    $companyLike .= "pec.companyname REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
                    $sectorLike .= "sector_business REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
                    $moreInfoLike .= "ma.MoreInfor REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
                    $investorLike .="ma.InvestmentDeals REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
                    $industryLike .= "ind.industry REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
                    $websiteLike .= "pec.website REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
                    $tagsLike .= "(pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,') and ";
                    
                }
                
                $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                $cityLike = '(' . trim($cityLike, 'AND ') . ')';
                $companyLike = '(' . trim($companyLike, 'AND ') . ')';
                $sectorLike = '(' . trim($sectorLike, 'AND ') . ')';
                $moreInfoLike = '(' . trim($moreInfoLike, 'AND ') . ')';
                $investorLike = '(' . trim($investorLike, 'AND ') . ')';
                $industryLike = '(' . trim($industryLike, 'AND ') . ')';
                $websiteLike = '(' . trim($websiteLike, 'AND ') . ')';
                $tagsLike = '(' . trim($tagsLike, 'and ') . ')';
                
                $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;


                    $companysql="SELECT ma.PECompanyId, pec.companyname, pec.industry, ind.industry, sector_business as sector_business,    ma.DealAmount,pec.website, ma.MandAId,ma.Comment,ma.MoreInfor,ma.hideamount,ma.ExitStatus,DATE_FORMAT(ma.DealDate,'%b-%Y') as period,DealDate as DealDate, 
                            (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                        JOIN pecompanies AS pec ON pec.PECompanyId = ma.PECompanyId
                        JOIN industry AS ind ON ind.industryid = pec.industry
                        JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                        JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                        JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                        LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                        LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                        LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                        LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                        where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and pec.industry != 15 and ma.DealTypeId= dt.DealTypeId and 
                        dt.hide_for_exit=$var_hideforexit  AND ( $tagsval ) $comp_industry_id_where group by ma.MandAId";

            $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
            $popup_search=1;
            //  echo "<br>Query for company search";
           // echo "<br> Company search--" .$companysql;
        }
        elseif (trim($companysearchads) != "")
        {
            $iftest=3;
            $yourquery=1;
            $datevalueDisplay1="";
            $datevalueCheck1="";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";
            
            $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
            pe.DealAmount,pec.website, pe.MandAId,pe.Comment,MoreInfor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            FROM manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt
            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
            AND pe.Deleted =0 and pec.industry != 15 " .$addedflagQry . $addedhide_pms_qry . $addDelind.
            " AND pec.PECompanyId IN ($companysearch) $comp_industry_id_wher   GROUP BY pe.MandAId ";
            
            $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
            //  echo "<br>Query for company search";
            //echo "<br> Company search--" .$companysql;
        }
        elseif (trim($sectorsearch) != "")
        {
            $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
            $sector_sql = array(); // Stop errors when $words is empty

            foreach($sectorsearchArray as $word){

                $word =trim($word);
    //                                                $sector_sql[] = " sector_business LIKE '$word%' ";
                $sector_sql[] = " sector_business = '$word' ";
                $sector_sql[] = " sector_business LIKE '$word(%' ";
                $sector_sql[] = " sector_business LIKE '$word (%' ";
            }
            $sector_filter = implode(" OR ", $sector_sql);
            
            $iftest=3;
            $yourquery=1;
            //$datevalueDisplay1="";
            $datevalueCheck1="";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";

            $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
            pe.DealAmount,pec.website, pe.MandAId,pe.Comment,MoreInfor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            FROM manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt
            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
            AND pe.Deleted =0 and pec.industry != 15 " .$addedflagQry . $addedhide_pms_qry . $addDelind.
            " AND ($sector_filter) $comp_industry_id_where GROUP BY pe.MandAId ";

            $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
            $popup_search=1;
                                 
            // echo "<br> sector search--" .$companysql;
        }
        elseif(trim($investorsearchsafs)!="")
        {
            if($_SESSION['PE_industries']!=''){

                $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
            }
                    $iftest=5;
            $yourquery=1;
            $datevalueDisplay1="";
            $datevalueCheck1="";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";

            $companysql="select pe.PECompanyId,c.companyname,c.industry,i.industry,
            pe.DealAmount,pe.MandAId,peinv_invs.InvestorId,invs.Investor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor  from
            manda_investors as peinv_invs,
            peinvestors as invs,
            manda as pe,
            pecompanies as c,industry as i,dealtypes as dt where DealDate between '" . $dt1. "' and '" . $dt2 . "' and  
            pe.MandAId=peinv_invs.MandAId and Deleted =0 and
            invs.InvestorId=peinv_invs.InvestorId and c.industry = i.industryid and
             c.PECompanyId=pe.PECompanyId and c.industry != 15 " .$addedflagQry . $addedhide_pms_qry. $addDelind.
            " AND invs.InvestorId IN($investorsearch)  and  peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId $comp_industry_id_where GROUP BY pe.MandAId ";
            
            $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
            //echo "<br> Investor search- ".$companysql;
        }
        elseif(trim($acquirersearch)!="")
        {
            if($_SESSION['PE_industries']!=''){

                $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
            }
            $iftest=6;
            $yourquery=1;
            $datevalueDisplay1="";
            $datevalueCheck1="";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";

            $companysql="SELECT pe.MandAId,pe.PECompanyId, c.companyname, c.industry, i.industry, sector_business as sector_business ,
            pe.DealAmount, hideamount, pe.AcquirerId, ac.Acquirer,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            FROM acquirers AS ac, manda AS pe, pecompanies AS c, industry AS i ,dealtypes as dt
            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   ac.AcquirerId = pe.AcquirerId
            AND c.industry = i.industryid
            AND c.PECompanyId = pe.PECompanyId and Deleted=0
            AND c.industry !=15 " .$addedflagQry . $addedhide_pms_qry. $addDelind.
            " AND ac.AcquirerId IN ($acquirersearch) $comp_industry_id_where GROUP BY pe.MandAId ";
            
            $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
                //echo "<br> Acquirer search- ".$companysql;
        }
        elseif(trim($advisorsearchstring_legal)!="")
        {
            if($_SESSION['PE_industries']!=''){

                $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
            }

            $iftest=7;
            $yourquery=1;
            //$datevalueDisplay1="";
            $datevalueCheck1="";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";

            $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,pe.DealAmount,
            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
            dealtypes as dt
            where DealDate between '" . $dt1. "' and '" . $dt2 . "' and
            Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId  " .$addedflagQry. $addhide_pms_qry.
            " and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='L' and 
            adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearchstring_legal%' $comp_industry_id_where  GROUP BY pe.MandAId)
            UNION
            (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
            cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount ,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
            peinvestments_advisorcompanies AS adcomp, acquirers AS ac ,dealtypes as dt
            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   Deleted=0 and c.industry = i.industryid
            AND ac.AcquirerId = pe.AcquirerId " .$addedflagQry . $addedhide_pms_qry . $addDelind.
            " AND c.PECompanyId = pe.PECompanyId
            AND adcomp.CIAId = cia.CIAID  and AdvisorType='L'
            AND adcomp.PEId = pe.MandAId
            AND cianame LIKE '%$advisorsearchstring_legal%' $comp_industry_id_where GROUP BY pe.MandAId)  ";
            
            $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
            $popup_search=1;
            //echo "<br> Advisor Acquirer search- ".$companysql;
        }
        elseif(trim($advisorsearchstring_trans)!="")
        {
            if($_SESSION['PE_industries']!=''){

                $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
            }
            
            $iftest=8;
            $yourquery=1;
            //$datevalueDisplay1="";
            $datevalueCheck1="";
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";

            $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,pe.DealAmount,
            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
            dealtypes as dt
            where DealDate between '" . $dt1. "' and '" . $dt2 . "' and
            Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId  " .$addedflagQry  .$addedhide_pms_qry. $addDelind.
            " and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='T' and
            adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearchstring_trans%' $comp_industry_id_where GROUP BY pe.MandAId )
            UNION
            (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
            cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
            peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt
            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   Deleted=0 and c.industry = i.industryid
            AND ac.AcquirerId = pe.AcquirerId " .$addedflagQry . $addedhide_pms_qry. $addDelind.
            " AND c.PECompanyId = pe.PECompanyId
            AND adcomp.CIAId = cia.CIAID  and AdvisorType='T'
            AND adcomp.PEId = pe.MandAId
            AND cianame LIKE '%$advisorsearchstring_trans%' $comp_industry_id_where GROUP BY pe.MandAId ) ";
            
            $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
            $popup_search=1;
        //echo "<br> Advisor Acquirer search- ".$companysql;
        }
       elseif (trim($investorsearch)!="" || trim($companysearch)!="" || count($industry) > 0 || count($sector) > 0 || count($subsector) > 0  || count($dealtype) > 0 || ($invtypevalue != "") || ($InType != "") || ($exitstatusvalue!="--") || ($range != "--") || (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--")) ||(($txtfrm>=0) && ($txtto>0)) || ($yearafter != "") || ($yearbefore != "") || ($investor_head != "--"))
        {    
            $iftest=2; 
            $yourquery=1;

            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-01";

            /*if ($sector != '' || $subsector != '') {
                $joinsectortable = ",pe_sectors as pe_sec,pe_subsectors as pe_sub";
                $wheresectortable = "and pec.PEcompanyID=pe_sub.PECompanyID  and pe_sec.sector_id = pe_sub.sector_id";
            }*/
            if ($sector != '' || $subsector != '') {
                $joinsectortable = ",pe_sectors as pe_sec,pe_subsectors as pe_sub";
                $wheresectortable = "and pec.PEcompanyID=pe_sub.PECompanyID  and pe_sec.sector_id = pe_sub.sector_id";
            }
            
            // $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
            // sector_business as sector_business,pe.ExitStatus, pe.DealAmount, i.industry, hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,
            // (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            // FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,
            // manda_investors as mandainv ,peinvestors as inv".$joinsectortable." where";
            $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
            sector_business as sector_business,pe.ExitStatus, pe.DealAmount, i.industry, hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,
            manda_investors as mandainv ,peinvestors as inv".$joinsectortable." where";

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
      
            if ($companysearch != '') {
                $combineSearchFlag = true;
                $wherecompanysql = " pec.PECompanyId IN($companysearch)";
             }
           if ($sector != '') {
            foreach($sector as $key=>$sectorval)
            {
                $sectorsql123="select sector_name from pe_sectors where sector_id=".$sectorval;
               
                $sectorquery=mysql_query($sectorsql123);
                if($row=mysql_fetch_row($sectorquery))
                {
                    $sector123.="'".$row[0]."'";
                    $sector123.=',';
                }
            }
            
           $sectorString= trim($sector123,",");
           if($sectorString!=''){
                $wheresectorsql = " pe_sec.sector_name IN($sectorString)";
            }
                  /*$sectorString = implode(',',$sector);
                  $wheresectorsql = " pe_sub.sector_id IN ($sectorString)";*/
            }

            if ($investorsearch != '') {
                 if($invandor == 0) {

                                 $query="select InvestorId,Investor from peinvestors where InvestorId IN(".$investorsearch.") order by InvestorId desc";
                                       // echo $query;
                                        $queryval=mysql_query($query);
                                       
                                         $invreg='REGEXP "';
                                        while($myrow=mysql_fetch_row($queryval))
                                        {
                                               // print_r($myrow);
                                            if($myrow[1] == 'Others'){
                                                $others = 1;
                                                break;
                                            }else{
                                                $others = 0;
                                            }

                                            $invreg.= $myrow[1];
                                            $invreg.= ".*";
                                            
                                        }
                                        if($others == 1){
                                            $invreg.= "Others.*";
                                        }
                                        $invreg=trim($invreg,".*");
                                 $invreg.='"';

                                  
                                 $invregsubquery=" and  (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ')
                 FROM manda_investors as peinv_inv,peinvestors as inv 
                 WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) ".$invreg;
                                }
                              //  echo $invregsubquery;
                  /*$ex_tags = explode(',', $investorsearch);
                    $invval= count($ex_tags)-1;
                    //echo $invval;
                   // exit();
                if ($invandor == 0) {
                        if (count($ex_tags) > 1) {
                        $having=" having count(mandainv.MandAId) >".$invval;
                        $groupby="";
                        }else{
                            $groupby="";
                            $having="";
                        }
                    }
                    else{
                        $having="";
                    }*/
                $combineSearchFlag = true;
                $whereinvestorsql = " inv.InvestorId IN($investorsearch)";
            }

            if ($subsector != '') {
                                    foreach ($subsector as $value){ 
                                        $subsectorString .= "'".$value."'" . ',';
                                    } 
                                    $subsectorString = trim($subsectorString, ',');
                                    if($subsectorString !=""){
                                    $wheresubsectorsql = " pe_sub.subsector_name IN($subsectorString)";
                                    }
                                }
            if ($dealtype!='' && (count($dealtype) >0))
            {
                $iftest=$iftest.".2";
                $dealSql = '';
                foreach($dealtype as $dealtypes)
                {
                    $dealSql .= " pe.DealTypeId = '".$dealtypes."' or ";
                }
                if($dealSql !=''){
                    $wheredealtype=  '('.trim($dealSql,' or ').')';
                    //$whereRound="pe.round LIKE '".$round."'";
                }
                $qryDealTypeTitle="Deal Type - ";
                $addedhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit in (0)";      
            }

            if ($InType!='' && $InType!='--')
            {                       
                $iftest=$iftest.".9";
                $wheretype = " pe.type ='" .$InType."'" ;                           
                $qryTypeTitle="Type - "; 
               
                 $addedhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit in (1)";                          
                
            }
                                            
            if ($invtypevalue!= "--" && $invtypevalue!= "")
            {
                $iftest=$iftest.".3";
                $qryInvType="Investor Type - " ;
                $whereInvType = " pe.InvestorType = '".$investorType."'";
            }
            if ($investor_head != "--" && $investor_head != '') {
                   $whereInvhead = "inv.countryid = '" . $investor_head . "'";
            }  
            
            if($exitstatusvalue!="--" && ($exitstatusvalue!=""))
            {     
                $iftest=$iftest.".4";
                $whereexitstatus=" pe.ExitStatus='".$exitstatusvalue."'" ;  
            }
            
            if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
            {
                $iftest=$iftest.".6";
                $qryDateTitle ="Period - ";
                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
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
            //echo "<bR>--" .$wheredates;
            if(trim($txtfrm>0) && trim($txtto==""))
            {
                $iftest=$iftest.".7";
                $qryReturnMultiple="Return Multiple - ";
                $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm .""   ;
            }
            elseif(trim($txtfrm=="") && trim($txtto>0))
            {
                $qryReturnMultiple="Return Multiple - ";
                $whereReturnMultiple=" mandainv.MultipleReturn < " .$txtto .""   ;
            }
            elseif(trim($txtfrm>  0) && trim($txtto >0))
            {
                $qryReturnMultiple="Return Multiple - ";
                $whereReturnMultiple=" mandainv.MultipleReturn > " .$txtfrm ." and mandainv.MultipleReturn < ".$txtto."" ;
            }

            if ($whereind != "")
            {
                $companysql=$companysql . $whereind ." and ";
                $aggsql=$aggsql . $whereind ." and ";
                $bool=true;
            }
            if ($whereinvestorsql != "") {
                $companysql = $companysql . $whereinvestorsql . " and ";
            }
            if ($wherecompanysql != "") {
                $companysql = $companysql . $wherecompanysql . " and ";
            }
            if ($wheresectorsql != "") {
                                    $companysql = $companysql . $wheresectorsql . " and ";
                                }
                                if ($wheresubsectorsql != "") {
                                    $companysql = $companysql . $wheresubsectorsql . " and ";
                                } 
            
            if (($wheredealtype != ""))
            {
                $companysql=$companysql . $wheredealtype . " and " ;
                $aggsql=$aggsql . $wheredealtype . " and " ;
                $bool=true;
            }

            if (($wheretype != ""))
            {
                $companysql=$companysql . $wheretype . " and " ;
                $aggsql=$aggsql . $wheretype . " and " ;
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
             if ($whereyearaftersql != "") {
                                    $companysql = $companysql . $whereyearaftersql . " and ";
                                }
                                if ($whereyearbeforesql != "") {
                                    $companysql = $companysql . $whereyearbeforesql . " and ";
                                }
                                if ($whereyearfoundedesql != "") {
                                    $companysql = $companysql . $whereyearfoundedesql . " and ";
                                }
                if (($whereInvhead != "")) {
                    $companysql = $companysql .$whereInvhead . " and ";
                    $aggsql = $aggsql . $whereInvhead . " and ";
                    $bool = true;
                }

            // $companysql = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
            // and  mandainv.MandAId=pe.MandAId $wheresectortable and inv.InvestorId=mandainv.InvestorId
            // and pec.industry != 15 and pe.Deleted=0" .$addedflagQry . $addedhide_pms_qry. $addDelind.$comp_industry_id_where. "  GROUP BY pe.MandAId ";

            $companysql = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
            and  mandainv.MandAId=pe.MandAId $wheresectortable and inv.InvestorId=mandainv.InvestorId
            and pec.industry != 15 and pe.Deleted=0" .$addedflagQry . $addedhide_pms_qry. $addDelind.$comp_industry_id_where.$invregsubquery."  GROUP BY pe.MandAId ";
            
           $orderby="DealDate";
            $ordertype="desc";
            $fetchRecords=true;
            $fetchAggregate==false;
            $popup_search = 1;
                                         //  echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
        }
        else
        {
            echo "<br> INVALID DATES GIVEN ";
            $fetchRecords=false;
            $fetchAggregate==false;
        }
                                  //  echo $companysql;
        $ajaxcompanysql=  urlencode($companysql);
        if($companysql!="" && $orderby!="" && $ordertype!="")
            $companysql = $companysql . " order by  DealDate desc,companyname asc "; 
        
        $topNav = 'Deals';
        $tour='Allow';
        $tourpage='mandaindex';
        include_once('mandaheader_search.php');
    ?>
    <script type="text/javascript">
       /* $('#expshowdeals').live('click',function(){ 
                $("#pelisting").submit();
                return false;
         });
         $(".export").click(function(){
             $("#pelisting").submit();
         });*/
    
    
                $("a.postlink").live('click',function(){
                   $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                  function resetinput(fieldname)
                {
                 
               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                //  alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
                
                function resetmultipleinput(fieldname,fieldid)
                {
                  $("#resetfield").val(fieldname);
                  $("#resetfieldid").val(fieldid);
                  
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }

                $(document).on('click', 'tr .details_link', function(){ 
                
                idval=$(this).attr("valueId");
                $("#detailpost").attr("href","mandadealdetails.php?value="+idval).trigger("click");
            });
                
            </script>
<style type="text/css">
.popup_searching label{
    font-size:12px !important;
}
    .inr-note{
            text-align: right;font-size: 12px;padding-top: 35px;margin: 0px;margin-right: 95px;
    }
    .is-inr{
            color: #bfa07c;
            float: left;
            font-size: 16px;
            padding: 0px 5px;
    }
</style>        
<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
  <td class="left-td-bg" id="tdfilter"><div class="acc_main" id="acc_main">
        <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active" id="openRefine">Slide Panel</a></div>
        <div id="panel" style="display:block; overflow:visible; clear:both;">
          <?php 
 
include_once('mandarefine.php');
?>
          <input type="hidden" name="resetfield" value="" id="resetfield"/>
          <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>
        </div>
      </div></td>
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
                                        echo $buttonClicked;
                    if(trim($buttonClicked==""))
                    {
                                            $totalDisplay="Total";
                                            $industryAdded ="";
                                            $totalAmount=0.0;
                                            $totalINRAmount=0.0;
                                            $totalInv=0;
                                            
                                            $cos_array=array();
                                             if($_SESSION['coscount']){ unset($_SESSION['coscount']); }
                                             
                                            $compDisplayOboldTag="";
                                            $compDisplayEboldTag="";
                                           // echo "<br> query final-----" .$companysql; 
                                          
                                            /* Select queries return a resultset */
                                            if ($companyrsall = mysql_query($companysql))
                                            {
                                                $company_cntall = mysql_num_rows($companyrsall);
                                                While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                                                {
                                                        $cos_array[]=$myrow["PECompanyId"];
                                                } 
                                            } 
                                            if($company_cntall > 0)
                                            {
                                                if($searchallfield!="")
                                                {
                                                    if($_SERVER["HTTP_REFERER"]!=''){
                        
                                                        $search_link = $_SERVER["HTTP_REFERER"];
                                                    }else{

                                                        $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                                    }
                                                    date_default_timezone_set('Asia/Calcutta');
                                                    $search_date=date('Y-m-d H:i:s');
                                                    $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('".$_SESSION['UserEmail']."','".$_SESSION['UserNames']."','".$searchallfield."',1,1,0,'".$search_date."','".$search_link."')";
                                                    mysql_query($search_query);
                                                }
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
                                                $companysqlwithlimit=$companysql." limit $offset, $rec_limit";
                                                if ($companyrs = mysql_query($companysqlwithlimit))
                                                {
                                                    $company_cnt = mysql_num_rows($companyrs);

                                                }
                                            }
                                            else
                                            {
                                                if($searchallfield!="")
                                                {
                                                    if($_SERVER["HTTP_REFERER"]!=''){

                                                        $search_link = $_SERVER["HTTP_REFERER"];
                                                    }else{

                                                        $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                                    }
                                                    date_default_timezone_set('Asia/Calcutta');
                                                    $search_date=date('Y-m-d H:i:s');
                                                    $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('".$_SESSION['UserEmail']."','".$_SESSION['UserNames']."','".$searchallfield."',0,1,0,'".$search_date."','".$search_link."')";
                                                    mysql_query($search_query);
                                                }
                                                $searchTitle= " No Exit(s) found for this search ";
                                                $notable=true;
                                            }
                                        
                                        
                                        $_SESSION['coscount'] = $comp_count = count(array_count_values($cos_array)); 
                                        if( isset( $_POST[ 'pe_checkbox' ] ) && !empty( $_POST[ 'pe_checkbox' ] ) ) {
                                            $pecheckcount = count( $pe_checkbox );
                                            $totalInv = @mysql_num_rows($companyrsall) - $pecheckcount;
                                            $_SESSION['totalcount'] = $totalInv;
                                        } else {
                                            $totalInv = @mysql_num_rows($companyrsall);
                                        }
                                        //========================================junaid==========================================
                                                foreach(array_count_values($cos_array) as $key=>$value){
                                                    $company_array[]=$key;
                                                }
                                                $comp_count = count(array_count_values($cos_array));
                                                $company_array_comma = implode(",",$company_array); // junaid
                                            //=========================================================================================
                                        //-------------------------------------junaid------------------------------------------------
                                            if( isset( $_POST[ 'pe_hide_companies' ] ) && !empty( $_POST[ 'pe_hide_companies' ] ) ) {
                                                $hideCountCh = count( $pe_hide_companies );
                                                $totalInv = $totalInv + $hideCountCh;
                                                $_SESSION['totalcount'] = $totalInv;
                                            }
                                        //-------------------------------------------------------------------------------------------
                                            
                                            if( isset( $_POST[ 'pe_amount' ] ) && !empty( $_POST[ 'pe_amount' ] ) ) {
                                                $totalAmount = $pe_amount;
                                            }
                                        if( $peEnableFlag ) {
                                            if( empty( $pe_company ) ) {
                                                $cos_array1  = '';
                                                $comp_count = 0;
                                            } elseif(!empty($_POST[ 'hide_pe_company'])){
                                                $cos_array1 = explode( ',', $_POST[ 'hide_pe_company'] );
                                                $total_cos = count(array_count_values($cos_array1));
                                            }else {
                                                $cos_array1 = explode( ',', $pe_company );
                                                $comp_count = count(array_count_values($cos_array1));
                                            }
                                        } else {
                                            $cos_array1 = $cos_array;
                                        }
                                        /*if( isset( $_POST[ 'pe_company' ] ) && !empty( $_POST[ 'pe_company' ] ) ) {
                                            $cos_array = explode( ',', $_POST[ 'pe_company' ] );
                                        }*/
                                        ?>
    <td class="profile-view-left" style="width:100%;">
        <div class="result-cnt" style="margin-bottom: 10px;">
        <?php if ($accesserror==1){?>
            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
            <?php
                exit; 
                } 
            ?>
            <div class="result-title">
                <div class="filter-key-result">  
                    <?php if(!$_POST)
                    { ?>
                        <div class="lft-cn"> 
                            <ul class="result-select">
                                <?php   if($datevalueDisplay1!=""){  
                                                             ?>
                                <li> <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                                <?php }
                                                    else if($datevalueCheck1 !="")
                                                    {
                                                    ?>
                                <li style="padding:1px 10px 1px 10px;"> <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?> </li>
                                <?php 
                                                    }
                                if(count($industry) > 0 && $industry!=null){ $drilldownflag=0; ?>
                                <li>
                                      <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                ?>
                            </ul>
                        </div>
                        <div class="result-rt-cnt">
                            <div class="result-count">
                                
                                <?php  
                                    if($studentOption==1)
                                    {
                                    ?>
                                        <span class="result-no"><span class="res_total"><?php echo $totalInv; ?></span> Results Found (across <span class="comp_total"><?php echo $comp_count; ?></span> cos) </span>
                                  <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <span class="result-no"><span class="res_total"><?php echo $totalInv; ?></span> Results Found (across <span class="comp_total"><?php echo $comp_count; ?></span> cos)</span>
                                  <?php
                                    }
                                    ?>
                                  <?php 
                                    if($VCFlagValueString=="0-1")
                                    {
                                    ?>
                                        <!-- <span class="result-for" style="float:left;"> for PE Exit  Public Market Sales</span> -->
                                        <span class="result-for" style="float:left;"></span>
                                  <?php }
                                    elseif($VCFlagValueString=="0-0") {
                                    ?>
                                  <!-- <span class="result-for" style="float:left;"> for PE Exits - M&A</span> -->
                                  <span class="result-for" style="float:left;"></span>
                                  <?php } 
                                            elseif ($VCFlagValueString=="1-0") { ?>
                                  <!-- <span class="result-for" style="float:left;"> for  VC Exits - M&A</span> -->
                                  <span class="result-for" style="float:left;"></span>
                                  <?php }
                                            elseif ($VCFlagValueString=="1-1") { ?>
                                  <!-- <span class="result-for" style="float:left;"> for VC Exit Public Market Sales</span> -->
                                  <span class="result-for" style="float:left;"></span>
                                  <?php }
                                  elseif($VCFlagValueString=="0-2") {
                                    ?>
                                  <span class="result-for" style="float:left;"> Merged View - for PE Exits</span>
                                  <?php } 
                                     ?> 
                                  <span class="result-amount"></span> <span class="result-amount-no" id="show-total-amount"></span> 
                                  <span class="result-amount-no" id="show-total-inr-amount"></span> <span class="is-inr">*</span>
                                  <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle"> <span> <img class="callout" src="images/callout.gif"> <strong>Definitions </strong> </span> </a>
                                <div class="title-links " id="export-btn"></div>
                            </div>
                            <p class="inr-note"><b>* Based on current USD / INR Rate</b></p>
                        </div>
                        
          
                    <?php 
                    }
                    else 
                    {    ?>  
                    <div class="lft-cn">      
                        <ul class="result-select">
                            <?php 
                            $cl_count = count($_POST);
                            if($cl_count >= 4)
                            {
                            ?>
                           <li class="result-select-close"><a id="overall-close" href="<?php echo BASE_URL; ?>dealsnew/mandaindex.php?value=<?php echo  $VCFlagValueString; ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                           <?php
                           }
                                if($InType!= "")
                                {
                                    if($InType==1)
                                    {
                                            $typeqryValue="IPO";
                                    }
                                    else if($InType==2)
                                    {
                                       $typeqryValue="Open Market Transaction";
                                    }
                                    else if($InType==3)
                                    {
                                            $typeqryValue="Reverse Merger";
                                    }else{
                                        $typeqryValue="";
                                    }
                                }
                                if(count($industry) > 0 && $industry!=null){ $drilldownflag=0; ?>
                                    <!-- <li> <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li> -->
                                    <?php $industryarray = explode(",",$industryvalue); 
                                    $industryidarray = explode(",",$industryvalueid); 
                                    foreach ($industryarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('industry',<?php echo $industryidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>

                              <?php } 
                              if ($sector > 0 && $sector != null) { $drilldownflag = 0;?>
                                <!-- <li>
                                    <?php echo $sectorvalue; ?><a  onclick="resetinput('sector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li> -->
                                 <?php
               $sectorarray = explode(",",$sectorvalue); 
                               $sectoridarray = explode(",",$sectorvalueid); 
                                    foreach ($sectorarray as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('sector',<?php echo $sectoridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                <?php }
                                
                                if ($subsector > 0 && $subsector != null) { $drilldownflag = 0;?>
                                 <!--  <li>
                                      <?php echo $subsectorvalue; ?><a  onclick="resetinput('subsector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li> -->
                                   <?php
               //$subsectorarray = explode(",",$subsector); 
                              // $stageidarray = explode(",",$stagevalueid); 
                                    foreach ($subsector as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('subsector','<?php echo $subsector[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                  <?php }
                                  
                                if($typeqryValue !=''){ ?>
                                    <li> <?php echo $typeqryValue; ?><a  onclick="resetinput('InType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php } 
                                if(count($dealtype) > 0&& $dealtype!=""){ $drilldownflag=0; ?>
                                    <!-- <li> <?php echo $dealtypevalue; ?><a  onclick="resetinput('dealtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li> -->
                                     <?php
                                 $dealarray = explode(",",$dealtypevalue); 
                               $dealidarray = explode(",",$dealtype_hide); 
                                    foreach ($dealarray as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('dealtype',<?php echo $dealidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                              <?php } 
                                if($investorType !="--" && $investorType!=null && $investorType !="" ){ $drilldownflag=0; ?>
                                    <li> <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php }  
                              if ($investor_head != "--" && $investor_head != null) {$drilldownflag = 0;?>
                              <li>
                                  <?php echo $invheadvalue; ?><a  onclick="resetinput('invhead');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                              </li>
                              <?php }
                              if($exitstatusdisplay!="") {  $drilldownflag=0;?>
                              <li> <?php echo $exitstatusdisplay;?><a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php }  
                                if($advisorsearchstring_legal!=" " && $advisorsearchstring_legal!="") { $drilldownflag=0; ?>
                                    <li> <?php echo $advisorsearchstring_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php } 
                                if($advisorsearchstring_trans!=" " && $advisorsearchstring_trans!=""){  $drilldownflag=0;?>
                                    <li> <?php echo $advisorsearchstring_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php }  if($datevalueDisplay1!=""){  ?>
                                    <li> <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php }
                                else if($datevalueCheck1 !=""){ ?>
                                    <li style="padding:1px 10px 1px 10px;"> <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?> </li>
                              <?php 
                                }
                                else if(trim($_POST['searchallfield'])!="" || trim($_POST['investorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['acquirersearch'])!="" || trim($_POST['advisorsearch_legal'])!="" || trim($_POST['advisorsearch_trans'])!="" ){ ?>
                                    <li style="padding:1px 10px 1px 10px;"> <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?> </li>
                              <?php
                                }
                                if(($txtfrm>=0) && ($txtto>0)) { $drilldownflag=0; ?>
                                    <li> <?php echo $txtfrm. "-" .$txtto?><a  onclick="resetinput('returnmultiple');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php } if($companysearch!=" " && $companysearch!=""){ $drilldownflag=0; ?>
                                <?php $companyarray = explode(",",$company_filter); 

            $companyidarray = explode(",",$company_id); 
                foreach ($companyarray as $key=>$value){  ?>
                  <li>
                      <?php echo $value; ?><a  onclick="resetmultipleinput('companysearch',<?php echo $companyidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?> 
                                   <!--  <li> <?php echo $company_filter;?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li> -->
                              <?php } if($invester_filter!=" " && $invester_filter!=""){$drilldownflag=0; ?>
                                    <!-- <li> <?php echo $invester_filter;?><a  onclick="resetinput('investorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li> -->
                                    <?php 
                                    $investerarray = explode(",",$invester_filter); 
                                    $investeridarray = explode(",",$invester_filter_id); 
                                    foreach ($investerarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('investorsearch',<?php echo $investeridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                              <?php } 
                                if($sectorsearch!=""){ $drilldownflag=0; ?>
                                    <li> <?php echo  stripslashes(str_replace("'","",trim($sectorsearch)));?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php }   if($acquirersearch!=" " && $acquirersearch!=""){$drilldownflag=0; ?>
                                    <li  > <?php echo $acquirerauto;?><a  onclick="resetinput('acquirersearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php }  
                              if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php }
                              if($searchallfield!=""){ $drilldownflag=0; ?>
                                    <li > <?php echo $searchallfield ; ?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                              <?php }
                              if($tagsearch!=''){ ?>
                                    <?php $tagarray = explode(",",$tagsearch); 

            //$exitidarray = explode(",",$exitstatusValue); 
                foreach ($tagarray as $key=>$value){  ?>
                  <li>
                      <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?>
                                    <!-- <li><?php echo "tag:".trim($tagsearch)?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
                                <?php
                                }
                                
                                $_POST['resetfield']="";
                                 foreach($_POST as $value => $link) 
                                 { 
                                     if($link == "" || $link == "--" || $link == " ") 
                                     { 
                                         unset($_POST[$value]); 
                                     } 
                                 }
                                 //print_r($_POST);
                                
                            ?>
                            </ul>
                        </div>
                        <div class="result-rt-cnt">
                            <div class="result-count"><h2 id="tour_result_title">
                                
                                <?php  
                                if($studentOption==1)
                                {
                                ?>
                                    <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!='' && $searchallfield!=''){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!='' && $searchallfield!=''){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span>
                                <?php  } ?>
                                <?php if($VCFlagValueString=="0-1")
                                {
                                ?>
                                    <span class="result-for" style="float:left;"> for PE Via Public Market Sales</span>
                                <?php }
                                elseif($VCFlagValueString=="0-0") {
                                    ?>
                                    <span class="result-for" style="float:left;"> for PE Exits - M&A</span>
                                <?php } 
                                elseif ($VCFlagValueString=="1-0") { ?>
                                    <span class="result-for" style="float:left;"> for  VC Exits - M&A</span>
                                <?php }
                                elseif ($VCFlagValueString=="1-1") { ?>
                                    <span class="result-for" style="float:left;"> for VC Exit Public Market Sales</span>
                                <?php } ?>
                                <span class="result-amount"></span> <span class="result-amount-no" id="show-total-amount"></span> 
                                <span class="result-amount-no" id="show-total-inr-amount"></span> <span class="is-inr">*</span>
                                <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle"> <span> <img class="callout" src="images/callout.gif"> <strong>Definitions </strong> </span> </a>
                                <div class="title-links" id="export-btn"></div>  
                            </div>
                            <p class="inr-note"><b>* Based on current USD / INR Rate</b></p>
                        </div>

                    <?php } ?>
                </div>
                </div>
            </div>
            <?php
            if($notable==false)
            { 
            ?>
        
        <!--<div class="list-tab step7">
          <ul>
            <li class="active"><a class="postlink"   href="<?php echo $pageTitle; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            
            <li><a id="icon-detailed-view" class="postlink" href="mandadealdetails.php?value=<?php echo $comid;?>/<?php echo $VCFlagValueString;?>" ><i></i> Detail  View</a></li>
          </ul>
        </div>-->
        
       
                          
            <?php
                $count=0;
                 While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                {
                        if($count == 0)
                        {
                                 $comid = $myrow["MandAId"];
                                $count++;
                        }
                }
            
                            if ($company_cntall>0)
                            {
                                    $hidecount=0;
                                    //Code to add PREV /NEXT
                                    $icount = 0;
                                    if ($_SESSION['resultId']) 
                                            unset($_SESSION['resultId']); 
                                     if ($_SESSION['resultCompanyId']) 
                                            unset($_SESSION['resultCompanyId']); 
                                    mysql_data_seek($companyrsall,0);
                                   While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                                    {
                                        //Session Variable for storing Id. To be used in Previous / Next Buttons
                                        $_SESSION['resultId'][$icount] = $myrow["MandAId"];
                                        $_SESSION['resultCompanyId'][$icount] = $myrow["PECompanyId"];
                                        $icount++;
                                        
                                        $industryAdded = $myrow["industry"];
                                        //$totalInv=$totalInv+1;
                                        $totalAmount=$totalAmount+ $myrow["DealAmount"];    
                                    }

                                    // $ch = curl_init("https://free.currencyconverterapi.com/api/v6/convert?q=USD_INR&compact=ultra&apiKey=fbebe88b3c481204f2fd");
                                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    // $var = curl_exec($ch);
                                    // curl_close($ch);
                                    // $var = json_decode($var, true);
                                    $inrvalue = "SELECT value FROM configuration WHERE purpose='USD_INR'";
                                    $inramount = mysql_query($inrvalue);
                                    while($inrAmountRow = mysql_fetch_array($inramount,MYSQL_BOTH))
                                    {
                                        $usdtoinramount = $inrAmountRow['value'];
                                    }
                                    $totalINRAmount = $totalAmount * 1000000 * $usdtoinramount / 10000000;

                            }
                            
                            //print_r($cos_array);
                        ?>
        <a id="detailpost" class="postlink"></a>
        <div class="view-table view-table-list step7">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
            <thead>
              <tr>
                <?php if( $searchallfield != '' )  { 
                    $uncheckRows = $_POST[ 'uncheckRows' ];
                    $pe_checkbox = explode( ',', $uncheckRows );
                    if(count($_POST[ 'uncheckRows' ]) > 0){
                        $allchecked='';
                    }else{
                        $allchecked='checked';
                    }

                    if($_POST['full_uncheck_flag']!='' && $_POST['full_uncheck_flag'] ==1 ){

                        $allchecked='';
                    }
                    ?>

                    <th class=""><input type="checkbox" class="all_checkbox" id="all_checkbox" <?php echo $allchecked; ?>/></th>
                <?php } 
                ?>
                <th style="width: 18%;" class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Company</th>
                <th style="width: 27%;" class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                <th style="width: 27%;" class="header <?php echo ($orderby=="investor")?$ordertype:""; ?>" id="investor">Exiting Investors</th>
                <th style="width: 11%;" class="header <?php echo ($orderby=="ExitStatus")?$ordertype:""; ?>" id="ExitStatus">Exit Status</th>
                <th style="width: 8%;" class="header <?php echo ($orderby=="DealDate")?$ordertype:""; ?>" id="DealDate">Date</th>
                <th class="header asc <?php echo ($orderby=="DealAmount")?$ordertype:""; ?>" id="DealAmount">Amount <br> Realized (US$M)</th>
              </tr>
            </thead>
            <tbody id="movies">
              <?php
                        if ($company_cnt>0)
                        {
                                $hidecount=0;
                                mysql_data_seek($companyrs,0);
                           While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                {
                                    $hideFlagset = 0;
                                        $prd=$myrow["period"];
                                        if($myrow["hideamount"]==1)
                                        {
                                                $hideamount="--";
                                                $hidecount=$hidecount+1;
                                        }
                                        else
                                        {
                                                $hideamount=$myrow["DealAmount"];
                                        }

                                        if(trim($myrow["sector_business"])=="")
                                                $showindsec=$myrow["industry"];
                                        else
                                                $showindsec=$myrow["sector_business"];
                                        
                                         if($myrow["ExitStatus"]==1)
                                        {
                                                $exitstus="Complete";
                                        }
                                        else if($myrow["ExitStatus"]==0)
                                        {
                                                 $exitstus="Partial";
                                        }
              ?>
              <?php 
                    if( $searchallfield != '' ) {
                       /* if( !empty( $pe_checkbox ) ) {
                            if( in_array( $myrow["MandAId"], $pe_checkbox ) ) {
                                $peChecked = '';
                                $rowClass = 'event_stop';
                                $unCheckAmount += $hideamount;
                            } else {
                                $peChecked = 'checked';
                                $rowClass = '';
                            }
                        } else {
                            $peChecked = 'checked';
                            $rowClass = '';
                        }*/
                         // ------------------------------------------junaid--------------------------------------------------
                                                        
                        if(count($pe_checkbox) > 0 && $pe_checkbox[0]!='' &&  count($pe_checkbox_enable) > 0 && $pe_checkbox_enable[0]!=''){

                                if( (in_array( $myrow["MandAId"], $pe_checkbox )) ) {
                                        $checked = '';
                                        $rowClass = 'event_stop';

                                } 
                                elseif( (in_array( $myrow["MandAId"], $pe_checkbox_enable )) ) {
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

                                if( (in_array( $myrow["MandAId"], $pe_checkbox )) ) {
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

                                if( (in_array( $myrow["MandAId"], $pe_checkbox_enable )) ) {
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
                        // --------------------------------------------------------------------------------------------
                        
                    }
                ?>

              <tr class="details_link <?php echo $rowClass; ?>" valueId="<?php echo $myrow["MandAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchallfield;?>">
                    <?php 
                        if( $searchallfield != '' ) {
                    ?>
                    <td><input type="checkbox" data-deal-amount="<?php echo $myrow['DealAmount']; ?>" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow[ 'PECompanyId' ]; ?>" class="pe_checkbox" <?php echo $checked; ?> value="<?php echo $myrow["MandAId"];?>" /></td>
                    <?php
                        }
                    ?>
                <?php

                                ?>
                <td id="tour<?php echo $myrow["MandAId"];?>" ><a class="postlink" id="vcexits<?php echo $myrow["MandAId"];?>" href="mandadealdetails.php?value=<?php echo $myrow["MandAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchallfield;?>"><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
                <td><a class="postlink" href="mandadealdetails.php?value=<?php echo $myrow["MandAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchallfield;?>"><?php echo trim($showindsec); ?></a></td>
                <td ><a class="postlink" href="mandadealdetails.php?value=<?php echo $myrow["MandAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchallfield;?>"><?php echo trim($myrow["Investor"]);?> </a> </td>
                <td><a class="postlink" href="mandadealdetails.php?value=<?php echo $myrow["MandAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchallfield;?>"><?php echo $exitstus; ?></a></td>
                <td><a class="postlink" href="mandadealdetails.php?value=<?php echo $myrow["MandAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchallfield;?>"><?php echo $prd;?></a> </td>
                <td style="text-align: right;"><a class="postlink" href="mandadealdetails.php?value=<?php echo $myrow["MandAId"];?>/<?php echo $flagvalue;?>/<?php echo $searchallfield;?>"><?php echo $hideamount; ?>&nbsp;</a></td>
                
              </tr>
              <?php

                            }
                     }
                    if( isset( $_POST[ 'pe_amount' ] ) && !empty( $_POST[ 'pe_amount' ] ) ) {
                        $totalAmount = $pe_amount;
                    }
                                ?>
            </tbody>
          </table>
        </div>
        <input type="hidden" name="pe_checkbox_disbale" id="pe_checkbox_disbale" value="<?php echo implode( ',', $pe_checkbox ); ?>">
         <input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>"> 
            <input type="hidden" name="pe_checkbox_amount" id="pe_checkbox_amount" value="">
            <input type="hidden" name="pe_checkbox_company" id="pe_checkbox_company" value="<?php echo implode( ',', $cos_array1 ); ?>">
            <?php 
             if( $searchallfield != '' ) { ?>
            
                <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php if($_POST['real_total_inv_deal']!=''){ echo $_POST['real_total_inv_deal']; }else{ echo $totalInv; } ?>">
                <input type="hidden" name="real_total_inv_amount" id="real_total_inv_amount" value="<?php if($_POST['real_total_inv_amount']!=''){ echo $_POST['real_total_inv_amount']; }else{ echo $totalAmount; } ?>">
                <input type="hidden" name="real_total_inv_inr_amount" id="real_total_inv_inr_amount" value="<?php if($_POST['real_total_inv_inr_amount']!=''){ echo $_POST['real_total_inv_inr_amount']; }else{ echo number_format(($totalINRAmount),"2"); } ?>">
                <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php if($_POST['real_total_inv_company']!=''){ echo $_POST['real_total_inv_company']; }else{ echo $comp_count; } ?>">
                
                <input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php if($_POST['total_inv_deal']!=''){ echo $_POST['total_inv_deal']; }else{  echo $totalInv; }?>">
                <input type="hidden" name="total_inv_amount" id="total_inv_amount" value="<?php if($_POST['total_inv_amount']!=''){ echo $_POST['total_inv_amount']; }else{  echo $totalAmount; }?>">
                <input type="hidden" name="total_inv_inr_amount" id="total_inv_inr_amount" value="<?php if($_POST['total_inv_inr_amount']!=''){ echo $_POST['total_inv_inr_amount']; }else{  echo number_format(($totalINRAmount),"2"); }?>">
                <input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php if($_POST['total_inv_company']!=''){ echo $_POST['total_inv_company']; }else{  echo $comp_count; }?>">
                <input type="hidden" name="all_checkbox_search" id="all_checkbox_search" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
                <input type="hidden" name="array_comma_company" id="array_comma_company" value="<?php echo $company_array_comma; ?>">
                
                <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST[ 'pe_hide_companies' ]; ?>">
                
           <?php } ?>
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
        <?php
        }
        
                if($hidecount==1)
                {
                        $totalAmount="--";
                        $totalINRAmount="--";
                } ?>
        <?php
                if($studentOption==1)
                {
                ?>
        <script type="text/javascript" >
                       $(document).ready(function(){
                       $("#show-total-amount").html('<h2>Amount Realized (US$M) <span><?php 
                       if($_POST['total_inv_amount']!='' && $searchallfield!=''){ echo  number_format($_POST['total_inv_amount'],2); }else{
                       if($totalAmount >0)
                       {
                           echo number_format($totalAmount,2);
                       }
                       else
                       {
                           echo "--";
                       }
                        }?></span></h2>');

                       $("#show-total-inr-amount").html('<h2 style="margin-left: 5px;">/ (INR CR) <span><?php 
                            if($_POST['total_inv_inr_amount']!='' && $searchallfield!=''){ echo  number_format($_POST['total_inv_inr_amount'],2); }else{
                            if($totalINRAmount >0)
                            {
                                echo number_format($totalINRAmount,2);
                            }
                            else
                            {
                                echo "--";
                            }
                        }?></span></h2>');

                       });
                   </script>
        <?php
                            if($exportToExcel==1)
                            {
                            ?>
        <?php  if($VCFlagValueString == '0-1' || $VCFlagValueString == '0-2'){?>
                                <script type="text/javascript" >
                                    $("#export-btn").html('<a class="export_new" name="showdeals" id="mandaexport" onClick="onClick_MandAExport(this.id);">Export</a>');
                                </script>
                                <span style="clear: both;float:left" class="one">
                                    <input type="button" class="export_new" id="mandaexportinv"  value="Export with Investments" name="showdeals" onClick="onClick_MandAExport_withInv(this.id);" >
                                </span> 
                                <span style="float:right;margin-right: 20px;" class="one">
                                    <a class="export_new" name="showdeals" id="mandaexport" onClick="onClick_MandAExport(this.id);">Export</a>
                                </span>
                            <?php }else{?>    
                                <script type="text/javascript" >
                                    $("#export-btn").html('<a class="export_new" name="showdeals" id="mandaexport" onClick="onClick_MandAExportDemo(this.id);">Export</a>');
                                </script>
                                <span style="clear: both;float:left" class="one">
                                <input type="button"   class="export_new" id="mandaexportinv"  value="Export with Investments" name="showdeals" onClick="onClick_MandAExport_withInv(this.id);" >
                                </span> <span style="float:right;margin-right: 20px;" class="one">
                                <a class="export_new" name="showdeals" id="mandaexport" onClick="onClick_MandAExportDemo(this.id);">Export</a>
                                </span>
                            <?php } ?>
        <?php
                            }
            }
            else
            {
                    //if($exportToExcel==1)
                    //{
                    ?>
                            <script type="text/javascript" >
                                $(document).ready(function(){
                                $("#show-total-amount").html('<h2>Amount Realized (US$M)<span>\n\
                                <?php  
                                if($_POST['total_inv_amount']!='' && $searchallfield!=''){ echo  number_format($_POST['total_inv_amount'],2); }else{
                                if($totalAmount >0)
                               {
                                   echo number_format($totalAmount,2);
                               }
                               else
                               {
                                   echo "--";
                               } 
                               }?></span></h2>');

                                $("#show-total-inr-amount").html('<h2 style="margin-left: 5px;">/ (INR CR) <span><?php 
                                    if($_POST['total_inv_inr_amount']!='' && $searchallfield!=''){ echo  number_format($_POST['total_inv_inr_amount'],2); }else{
                                    if($totalINRAmount >0)
                                    {
                                        echo number_format($totalINRAmount,2);
                                    }
                                    else
                                    {
                                        echo "--";
                                    }
                                }?></span></h2>');

                                            });
                                        </script>


        <?php
                    /*}
                    else
                    {
                    ?>
                        <script type="text/javascript" >
                                                        $("#show-total-deal").html('XXX Results found ');
                                                       $("#show-total-amount").html('<h2>Amount Realized (US$M) YYY</h2>');
                                                 </script>
                                                 <br><div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
                    <?php
                    }*/
                ?>
       <?php
                    if(($totalInv>0)  &&  ($exportToExcel==1))
                    {
                ?>
                <?php  if($VCFlagValueString == '0-1' || $VCFlagValueString == '0-2'){?>
                    <script type="text/javascript" >
                        $(document).ready(function(){
                            $("#export-btn").html('<a class="export_new" id="mandaexport" name="showmandadeals" onClick="onClick_MandAExport(this.id);" >Export</a>');
                        });
                    </script>
                    <div style="clear: both;" > 
                        <span style="float:right;margin-right:20px;" class="one">
                            <a class="export_new" name="showmandadeals" id="mandaexport" onClick="onClick_MandAExport(this.id);"  >Export</a>
                        </span> 
                        <span style="float:left; margin-left: 20px;" class="one">
                            <input type="button"   class="export_new"  id="mandaexportinv" value="Export with Investments" name="showdeals" onClick="onClick_MandAExport_withInv(this.id);" >
                        </span> 
                    </div>
                <?php }else{ ?>
                    <script type="text/javascript" >
            $(document).ready(function(){
            $("#export-btn").html('<a class="export_new" id="mandaexport" name="showmandadeals" onClick="onClick_MandAExportDemo(this.id);" >Export</a>');
            });
        </script>
        <div style="clear: both;" > <span style="float:right;margin-right:20px;" class="one">
          <a class="export_new" name="showmandadeals" id="mandaexport"  onClick="onClick_MandAExportDemo(this.id);"  >Export</a>
          </span> <span style="float:left; margin-left: 20px;" class="one">
          <input type="button"   class="export_new"  id="mandaexportinv" value="Export with Investments" name="showdeals" onClick="onClick_MandAExport_withInv(this.id);" >
          </span> </div>
        <?php } ?>
          <!-- quick search -->
          <?php

if ($popup_search == 0) {?>
          <script>
                $(document).ready(function(){
                 $('.popup_close a').click(function(){
                     $(".popup_main").hide();
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
.popup_box {
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
              <option value="exact">All(Exact Match)</option>
              <option value="investor">Investor</option>
              <option value="company">Company</option>
              <option value="sector">Sector</option>
              <option value="legal_advisor">Legal Advisor</option>
              <option value="transaction_advisor">Transaction Advisor</option>
              <option value="tags">Tags</option>
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
    </div>

          <div style="clear: both;" ></div>
<?php }
                    }
                    elseif(($totalInv>0) && ($exportToExcel==0))
                    {
                    ?>
        <div> <span>
          <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing Exits via M&A. </p>
          <span style="float:right;margin-right:20px;" class="one">
          <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
          <a class ="export" target="_blank" href=<?php echo $samplexls;?>>Sample Export</a> </span>
          <div style="clear: both;" ></div>
          <script type="text/javascript">
                                                 $('#export-btn').html('<a class="export"  href=<?php echo $samplexls;?>>Export Sample</a>');
                                                </script>
          </span> </div>
        <?php
                    }
            } //end of student if
                ?>
        <?php
                    }
                    elseif($buttonClicked=='Aggregate')
                    {

                        $aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry.
                                     " order by pe.DealAmount desc,DealDate desc";
                        //  echo "<br>--" .$aggsql;
                             if ($rsAgg = mysql_query($aggsql))
                             {
                                $agg_cnt = mysql_num_rows($rsAgg);
                             }
                               if($agg_cnt > 0)
                               {
                                    //$searchTitle=" Aggregate Deal Data";

                                     While($myrow=mysql_fetch_array($rsAgg, MYSQL_BOTH))
                                       {
                                            $totDeals = $myrow["totaldeals"];
                                            $totDealsAmount = $myrow["totalamount"];
                                        }
                               }
                               else
                               {
                                    $searchTitle= " No Exit(s) found for this search";
                               }
                               if(count($industry) > 0)
                               {
                                  $indSql= "select industry from industry where industryid=$industry";
                                  if($rsInd=mysql_query($indSql))
                                  {
                                      while($myindRow=mysql_fetch_array($rsInd,MYSQL_BOTH))
                                      {
                                        $indqryValue=$myindRow["industry"];
                                      }
                                   }
                                }
                                if(count($dealtype) > 0)
                                {
                                    $dealSql= "select DealType from dealtypes where DealTypeId=$dealtype";
                                    if($rsDealType=mysql_query($dealSql))
                                    {
                                      while($mydealRow=mysql_fetch_array($rsDealType,MYSQL_BOTH))
                                      {
                                        $dealqryValue=$mydealRow["DealType"];
                                      }
                                    }
                                 }
                                if($range!= "--")
                                {
                                    $rangeqryValue= $range;
                                }
                                if($InType!= "")
                                {
                                    if($InType==1)
                                    {
                                        $typeqryValue="IPO";
                                    }
                                    else if($InType==2)
                                    {
                                       $typeqryValue="Open Market Transaction";
                                    }
                                    else
                                    {
                                        $typeqryValue="Reverse Merger";
                                    }
                                }
                                if($wheredates !== "")
                                {
                                    $dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
                                }
                                $searchsubTitle="";
                                if((count($industry)==0) && ( count($dealtype)==0 && ($range=="--") && ($wheredates=="")))
                                {
                                    $searchsubTitle= "All";
                                }

                    ?>
        <div id="headingtextpro">
          <div id="headingtextproboldfontcolor"> <?php echo $searchAggTitle; ?> <br />
            <br />
          </div>
          <div id="headingtextprobold"> Search By : <?php echo $searchsubTitle; ?> <br />
            <br />
          </div>
          <?php
                        $spacing="<Br />";
                        if (count($industry) > 0)
                        {
                    ?>
          <?php echo $qryIndTitle; ?><?php echo $indqryValue; ?> <?php echo $spacing; ?>
          <?php
                        }
                        if($dealtype !="" && count($dealtype) > 0)
                        {
                        
                    ?>
          <?php echo $qryDealTypeTitle; ?><?php echo $dealqryValue; ?> <?php echo $spacing; ?>
          <?php
                        }// echo $typeqryValue;
                        if($InType!="")
                        { 
                    ?>
          <?php echo $qryTypeTitle; ?><?php echo $typeqryValue; ?> <?php echo $spacing; ?>
          <?php
                        }
                        if($range!="--")
                        {
                    ?>
          <?php echo $qryRangeTitle; ?><?php echo $rangeqryValue; ?> <?php echo $spacing; ?>
          <?php
                        }
                        if($wheredates!="--")
                        {
                    ?>
          <?php echo $qryDateTitle; ?><?php echo $dateqryValue; ?> <?php echo $spacing; ?>
          <?php
                        }
                    ?>
          <div id="headingtextprobold"> <br />
            No of Deals : <?php echo $totDeals; ?> <br />
            <br/>
          </div>
          <div id="headingtextprobold"> Value (US $M) : <?php echo $totDealsAmount; ?> <br />
          </div>
        </div>
        <?php
                    }
            ?>
      </div>
  </div>
  <?php /*if( $company_cnt > 0 ) {*/ ?>
  <div class="other_db_search">
    <div class="other_db_searchresult">
      <p class="other_loading">Please wait while we search for results in other databases<br>
        <img  src="images/other_loading.gif"></p>
    </div>
  </div>
  <?php /*}*/ ?>
  <div class="overview-cnt mt-trend-tab">
          <div class="showhide-link"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? '' : ''; ?>" rel="#slidingTable" id='ldtrend'><i></i><span>Trend View</span></a></div>
          <div  id="slidingTable" style="display: none;overflow:hidden;">
            <?php
                      include_once("mandatrendview.php");
               ?>
            <table width="100%">
              <?php
                                        if($type!=1)
                                        {
                                         ?>
              <tr>
                <td width="50%" class="profile-view-left"><div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div></td>
                <td class="profile-view-rigth" width="50%" ><div id="visualization3" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div></td>
              </tr>
              <tr>
                <td width="50%" class="profile-view-left" id="chartbar"><div id="visualization1" style="max-width: 100%; height: 750px;overflow-x: auto;overflow-y: hidden;"></div></td>
                <td  id="chartbar" class="profile-view-rigth" width="50%" ><div id="visualization" style="max-width: 100%; height: 700px;overflow-x: auto;overflow-y: hidden;"></div></td>
              </tr>
              <?php
                                        }
                                        else
                                        {
                                        ?>
              <tr>
                <td width="100%" class="profile-view-left" colspan="2"><div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div></td>
              </tr>
              <?php
                                        }
                                        ?>
              <tr>
                <td class="profile-view-left" colspan="2"><div class="showhide-link link-expand-table">
                    <?php if ($vcflagValue == 0 || $hide_pms==1) { ?>
                    <input style="float:right;margin-top:9px;margin-right:5px;" class ="export" type="button" id="exporttrend"  value="Export" name="exporttrend">
                    <?php } ?>
                    <a href="#" class="show_hide" rel="#slidingDataTable">View Table</a> </div>
                  <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;">
                    <div class="restable">
                      <table class="testTable1" cellpadding="0" cellspacing="0" id="restable">
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                    </div>
                  </div></td>
              </tr>
            </table>
          </div>
        </div>
  </td>
  
  </tr>
  <input type="hidden" name="period_flag" id="period_flag" value="<?php echo $period_flag; ?>" />
</table>
</div>
<div class=""></div>
</div>
</form>
<form name="mandaview" id="pelisting " method="post" >
  <?php if($_POST) { $hide_pms=$VCFlagValue_exit[1];?>
  <input type="hidden" name="txtsearchon" value="3" >
  <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
  <input type="hidden" name="txthide_pms" value=<?php echo $hide_pms;?> >
  <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
  <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
  <input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
  <input type="hidden" name="txthideindustryid" value=<?php echo $industry_hide; ?> >
  <input type="hidden" name="txthidetype" value=<?php echo $InType; ?> >
  <input type="hidden" name="txthidedealtype" value=<?php echo $dealtypevalue; ?> >
  <input type="hidden" name="txthidedealtypeid" value=<?php echo $dealtype_hide; ?> >
  <input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
  <input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
  <input type="hidden" name="txthideInType" value=<?php echo $InType; ?> >
  <input type="hidden" name="txthideexitstatusvalue" value=<?php echo $exitstatusvalue; ?> >
  <input type="hidden" name="txthiderange" value=<?php echo $rangeText; ?> >
  <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
  <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
  <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
  <input type="hidden" name="txthideReturnMultipleFrm" value=<?php echo $txtfrm; ?> >
  <input type="hidden" name="txthideReturnMultipleTo" value=<?php echo $txtto; ?> >
  <input type="hidden" name="txthideinvestor" value=<?php echo $investorsearchhidden; ?> >
  <input type="hidden" name="txthideInvestorString" value=<?php echo $stringToHideInvestor; ?> >
  <input type="hidden" name="txthidecompany" value=<?php echo $companysearch; ?> >
  <input type="hidden" name="txthideCompanyString" value=<?php echo $stringToHideCompany; ?> >
  <input type="hidden" name="txthidesectorsearch" value="<?php echo $sectorvalue; ?>" >
  <input type="hidden" name="txthidesectorsearchval" value="<?php echo $sectorsearch; ?>" >
  <input type="hidden" name="txthidesubsectorsearch" value="<?php echo $subsectorvalue; ?>" >
  <input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
  <input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
  <input type="hidden" name="txthideacquirer" value=<?php echo $acquirersearch; ?> >
  <input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
   <input type="hidden" name="yearafter" value=<?php echo $yearafter; ?> >
    <input type="hidden" name="yearbefore" value=<?php echo $yearbefore; ?> >
    <input type="hidden" name="invhead" value=<?php echo $investor_head; ?> >
    <input type="hidden" name="tagsearchval" value=<?php echo $tagsearch; ?> >
  <input type="hidden" id="invradio" name="invradio" value="<?php if($invandor!=''){echo $invandor;}else {echo 0;}?>" placeholder="" style="width:220px;"> 
    <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode( ',', $pe_checkbox ); ?>">
    <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
    <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
    <!-- T960 -->
    <input type="hidden" class="resultarray" name="resultarray" value=""/>
    <!-- T960 end -->
  <?php } else { $hide_pms=$VCFlagValue_exit[1];?>
  <input type="hidden" name="txtsearchon" value="3" >
  <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
  <input type="hidden" name="txthide_pms" value=<?php echo $hide_pms;?> >
  <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
  <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
  <input type="hidden" name="txthideindustry" value="">
  <input type="hidden" name="txthideindustryid" value="--">
  <input type="hidden" name="txthidedealtype" value=<?php echo $dealtypevalue; ?> >
  <input type="hidden" name="txthidetype" value="" >
  <input type="hidden" name="txthidedealtypeid" value="--">
  <input type="hidden" name="txthideinvtype" value="">
  <input type="hidden" name="txthideinvtypeid" value="--">
  <input type="hidden" name="txthideinInType" value="--">
  <input type="hidden" name="txthideexitstatusvalue" value="--">
  <input type="hidden" name="txthiderange" value="">
  <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
  <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
  <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
  <input type="hidden" name="txthideReturnMultipleFrm" value="">
  <input type="hidden" name="txthideReturnMultipleTo" value="">
  <input type="hidden" name="txthideReturnMultipleFrm" value="">
  <input type="hidden" name="txthideReturnMultipleTo" value="">
  <input type="hidden" name="txthideinvestor" value="">
  <input type="hidden" name="txthideInvestorString" value="+">
  <input type="hidden" name="txthidecompany" value="">
  <input type="hidden" name="txthideCompanyString" value="+">
  <input type="hidden" name="txthideadvisor_legal" value="">
  <input type="hidden" name="txthideadvisor_trans" value="">
  <input type="hidden" name="txthideacquirer" value="">
  <input type="hidden" name="txthidesearchallfield" value="">
   <input type="hidden" name="yearafter" value="">
    <input type="hidden" name="yearbefore" value="">
    <input type="hidden" name="invhead" value="" >
    <input type="hidden" id="invradio" name="invradio" value="<?php if($invandor!=''){echo $invandor;}else {echo 0;}?>" placeholder="" style="width:220px;"> 
      <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode( ',', $pe_checkbox ); ?>">
    <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
    <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
    <!-- T960 -->
    <input type="hidden" class="resultarray" name="resultarray" value=""/>
    <!-- T960 end -->
  <?php }
        ?>
</form>
<?php if($type==4){ ?>
<form name="exporttrend" id="exporttable"  method="post" action="ajxmandaExcel.php">
  <input type="hidden" id="exporttablesql" name="exporttablesql" value="<?php echo $compRangeSql; ?>" >
  <input type="hidden" id="vcflagValue" name="vcflagValue" value="<?php echo $vcflagValue; ?>" >
  <input type="hidden" id="hide_pms" name="hide_pms" value="<?php echo $hide_pms; ?>" >
  <input type="hidden" id="type" name="type" value="<?php echo $type; ?>" >
  <input type="hidden" id="range" name="range" value="<?php echo implode('#',$range);?>" >
   <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode( ',', $pe_checkbox ); ?>">
    <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
    <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
</form>
<?php  }else{ ?>
<form name="exporttrend" id="exporttable"  method="post" action="ajxmandaExcel.php">
  <input type="hidden" id="exporttablesql" name="exporttablesql" value="<?php echo $companysql; ?>" >
  <input type="hidden" id="vcflagValue" name="vcflagValue" value="<?php echo $vcflagValue; ?>" >
  <input type="hidden" id="hide_pms" name="hide_pms" value="<?php echo $hide_pms; ?>" >
  <input type="hidden" id="type" name="type" value="<?php echo $type; ?>" >
   <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode( ',', $pe_checkbox ); ?>">
    <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
    <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
</form>
<?php  } ?>
<script type="text/javascript">
    
    // Start T960 ------------------------------------------------------->
    function onClick_MandAExport(id)
    {
        jQuery('#agreebtn').attr('data-export', id);
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        $('.exportcheck').iCheck('destroy');
        $('.allexportcheck').iCheck('destroy');
        $('.companyexportcheck').iCheck('destroy');
        $('.allexportcheck').iCheck('check');
        $(".resultarray").val('Select-All');
        $('.exportcolumn .exportcheck').attr('checked', true); 
        return false;
    }
    function onClick_MandAExportDemo(id)
    {
        jQuery('#agreebtn').attr('data-export', id);
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights-filter').fadeIn();   
        return false;
    }
    // End T960 ------------------------------------------------------------>

    function onClick_MandAExport_withInv(id)
    {
        jQuery('#agreebtn').attr('data-export', id);
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
       // jQuery('#preloading').fadeIn();   
        //document.mandaview.action="exportmandaexit_invdeals.php";
        //document.mandaview.submit();
        //initExport('exportmandaexit_invdeals.php');
    }
    
    function initExport(expFile){
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
                        hrefval= expFile;
   
                        //$("#pelisting").attr("action", hrefval);
                        //$("#pelisting").submit();
                        document.mandaview.action=hrefval;
                        document.mandaview.submit();
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
    
                
                
                
                
</script>
<input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
<input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
<input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
<script src="js/listviewfunctions.js"></script>
<script type="text/javascript">
            orderby='<?php echo $orderby; ?>';
            ordertype='<?php echo $ordertype; ?>';
           $(".jp-next").live("click",function(){
               if(!$(this).hasClass('jp-disabled')){
               pageno=$("#next").val();
               loadhtml(pageno,orderby,ordertype);}
               return  false;
           });
           $(".jp-page").live("click",function(){
               pageno=$(this).text();
               loadhtml(pageno,orderby,ordertype);
               return  false;
           });
           $(".jp-previous").live("click",function(){
               if(!$(this).hasClass('jp-disabled')){
               pageno=$("#prev").val();
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
           $(document).ready(function(){ 

            $( '#month1' ).on( 'change', function() {
                $( '#period_flag' ).val(2);
            });
            $( '#year1' ).on( 'change', function() {
                $( '#period_flag' ).val(2);
            });
            $( '#month2' ).on( 'change', function() {
                $( '#period_flag' ).val(2);
            });
     });              
          function loadhtml(pageno,orderby,ordertype)
          {
            var peuncheckVal = $( '#pe_checkbox_disbale' ).val();
            var full_check_flag =  $( '#all_checkbox_search' ).val();//junaid
            var pecheckedVal = $( '#pe_checkbox_enable' ).val();//junaid
           jQuery('#preloading').fadeIn(1000);   
           $.ajax({
           type : 'POST',
           url  : 'ajaxListview_manda.php',
           data: {

                   sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                   totalrecords : '<?php echo addslashes($company_cntall); ?>',
                   page: pageno,
                   flagvalue:'<?php echo $flagvalue; ?>',
                   hide_pms:'<?php echo $hide_pms; ?>',
                   orderby:orderby,
                   ordertype:ordertype,
                    searchField: '<?php echo $searchallfield; ?>',
                    uncheckRows: peuncheckVal,
                    checkedRow:pecheckedVal, //junaid
                    full_uncheck_flag :  full_check_flag //junaid
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
            var pehideFlag = '';
            $( '.pe_checkbox' ).on( 'ifChanged', function(event) {
                
                var amountChnage = true;
                var peuncheckCompdId = $( event.target ).val();
                var peuncheckAmount = $(event.target).data('deal-amount');
                var peuncheckINRAmount = $(event.target).data('deal-amount');
                var peuncheckCompany = $( event.target ).data( 'company-id' );
                pehideFlag = $(event.target).data('hide-flag');
                var total_invdeal = $("#real_total_inv_deal").val(); //junaid
                
                var total_invcompany = $("#real_total_inv_company").val();//junaid
                
                if( peuncheckAmount == '--' || pehideFlag == 1 ) {
                    amountChnage = false;
                } else {
                    peuncheckAmount = parseFloat( $(event.target).data('deal-amount') );
                    peuncheckINRAmount = parseFloat( $(event.target).data('deal-amount') );
                }
                var cur_val = $("#pe_checkbox_disbale").val();
                var cur_val1 = $("#hide_company_array").val();//junaid
                var cur_va2 = $("#pe_checkbox_enable").val();//junaid
                
                var lastElement = $(event.target).parents('#myTable tbody .details_link').is(':last-child');
                
                if( $( event.target ).prop('checked') ) {
                    
                    $(event.target).parents('.details_link').removeClass('event_stop');
                    
                    //------------------------------junaid--------------------------------
                    if( cur_va2 != '' ) {
                        $('#pe_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );
                        $('#export_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );
                       
                    } else {
                        $('#pe_checkbox_enable').val( peuncheckCompdId );
                        $('#export_checkbox_enable').val( peuncheckCompdId );
                        
                    }
                //----------------------------------------------------------------------------------
                
                    var strArray = cur_val.split(',');
                    for( var i = 0; i < strArray.length; i++ ) {
                        if ( strArray[i] === peuncheckCompdId ) {
                            strArray.splice(i, 1);
                        }
                    }
                    $('#pe_checkbox_disbale').val( strArray );
                    $('#txthidepe').val( strArray );
                    
                    //------------------------------junaid--------------------------------
                    var strArray1 = cur_val1.split(',');
                    for( var i = 0; i < strArray1.length; i++ ) {
                        if ( strArray1[i] === peuncheckCompdId ) {
                            strArray1.splice(i, 1);
                        }
                    }
                    if( pehideFlag == 1 ) {
                        $( '#hide_company_array' ).val( strArray1 );
                    }
               //-------------------------------------------------------------- 
                    updateCountandAmount( peuncheckINRAmount, peuncheckAmount, 'add', amountChnage, pehideFlag, total_invdeal );
                    updateCompanyCount( peuncheckCompany, 'add', lastElement, pehideFlag,total_invcompany );
                } else {
                    
                    $(event.target).parents('.details_link').addClass('event_stop');
                //------------------------------junaid--------------------------------   
                    var strArray2 = cur_va2.split(',');
                    for( var i = 0; i < strArray2.length; i++ ) {
                        if ( strArray2[i] === peuncheckCompdId ) {
                            strArray2.splice(i, 1);
                        }
                    }
                    $('#pe_checkbox_enable').val( strArray2 );
                    $('#export_checkbox_enable').val( strArray2 );
                //-------------------------------------------------------------- 
                    if( cur_val != '' ) {
                        $('#pe_checkbox_disbale').val( cur_val + "," + peuncheckCompdId );
                        $('#txthidepe').val( cur_val + "," + peuncheckCompdId );
                    } else {
                        $('#pe_checkbox_disbale').val( peuncheckCompdId );
                        $('#txthidepe').val( peuncheckCompdId );
                    }
                    
                    //------------------------------jagadeesh rework--------------------------------     
                    if( pehideFlag == 1 ) {
                        if( cur_val1 != '' ) {
                            $('#hide_company_array').val( cur_val1 + "," + peuncheckCompdId );
                        } else {
                            $('#hide_company_array').val( peuncheckCompdId );
                        }
                    }
                    //---------------------------------------------------------------
                    updateCountandAmount( peuncheckINRAmount, peuncheckAmount, 'remove', amountChnage, pehideFlag, total_invdeal );
                    updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag,total_invcompany );
                }
                
            });
            
             //------------------------------junaid--------------------------------
                   
             $( '.all_checkbox' ).on( 'ifChanged', function(event) {
                
                 if( $( event.target ).prop('checked') ) {
               
                    $( '#pe_checkbox_company' ).val($("#array_comma_company").val());
                   
                    $( '.result-count .result-no span.res_total' ).text( $("#real_total_inv_deal").val() );
                    $( '#show-total-amount h2 span' ).text($("#real_total_inv_amount").val() );
                    $( '#show-total-inr-amount h2 span' ).text($("#real_total_inv_inr_amount").val() );
                    $( '.result-count .result-no span.comp_total' ).text($("#real_total_inv_company").val());
                    $( '#pe_checkbox_disbale' ).val('');
                    
                    $( '#total_inv_deal' ).val($("#real_total_inv_deal").val());
                     $( '#total_inv_amount' ).val($("#real_total_inv_amount").val());
                     $( '#total_inv_inr_amount' ).val($("#real_total_inv_inr_amount").val());
                     $( '#total_inv_company' ).val($("#real_total_inv_company").val());
                     
                     $( '#pe_checkbox_enable' ).val('');
                     $( '#export_checkbox_enable' ).val('');
                     $( '#all_checkbox_search' ).val('');
                     $( '#export_full_uncheck_flag' ).val('');
                     $( '#hide_company_array' ).val('');
                     
                     $( '#expshowdeals').show();
                     
                     $('.pe_checkbox').each(function(){ //iterate all listed checkbox items
                        $(this).prop("checked",true);
                        $(this).parents('.details_link').removeClass('event_stop');
                        $(this).parents('.icheckbox_flat-red').addClass('checked');
                    });
                    
                 }else{
                     
                     $(event.target).parents('.details_link').addClass('event_stop');
                     $( '#pe_checkbox_company' ).val('');
                     $( '#pe_checkbox_enable' ).val('');
                     $( '#export_checkbox_enable' ).val('');
                     $( '#pe_checkbox_disbale').val('');
                     $( '.result-count .result-no span.res_total' ).text('0');
                     $( '#show-total-amount h2 span' ).text('0');
                     $( '#show-total-inr-amount h2 span' ).text(0 );
                     $( '.result-count .result-no span.comp_total' ).text('0');
                     $( '#total_inv_deal' ).val('0');
                     $( '#total_inv_amount' ).val('0');
                     $( '#total_inv_inr_amount' ).val('0');
                     $( '#total_inv_company' ).val('0');
                     $( '#all_checkbox_search' ).val('1');
                     $( '#export_full_uncheck_flag' ).val('1');
                     $( '#hide_company_array' ).val('');
                     $( '#expshowdeals').hide();
                     
                    $('.pe_checkbox').each(function(){ //iterate all listed checkbox items

                        $(this).parents('.details_link').addClass('event_stop');
                        $(this).prop('checked',false);
                    });
                    $('.icheckbox_flat-red').removeClass('checked');
                   
                 }
            });
        //---------------------------------------------------------------------------------------
        

            function updateCountandAmount(  elementINRAmount, elementAmount, type, amountFlag, pehideFlag , total_invdeal) {
                var totalFound = parseFloat( $( '.result-count .result-no span.res_total' ).text() );
                var currentusd = <?php echo $usdtoinramount.";" ?>
                var labelAmount = $( '#show-total-amount h2 span' ).text();
                var labelINRAmount = $( '#show-total-inr-amount h2 span' ).text();
                var amountChange = true;
                if( labelAmount == '--' ) {
                    amountChange = false;  
                } else {
                    var totalResAmount = parseFloat( labelAmount.replace(',','').replace(' ','') );
                    var totalResINRAmount = parseFloat( labelINRAmount.replace(',','').replace(' ','') );
                }
                if( type == 'add' ) {
                    var currAmount = totalResAmount + elementAmount;
                    var currINRAmount = currAmount * 1000000 * currentusd / 10000000;
                   if(pehideFlag!=1){
                        var currTotal = totalFound + 1;
                    }else{
                        var currTotal = totalFound;
                    }
                } else {
                    var currAmount = totalResAmount - elementAmount;
                    var currINRAmount = currAmount * 1000000 * currentusd / 10000000;
                    if(pehideFlag!=1){
                        var currTotal = totalFound - 1;
                    }else{
                        var currTotal = totalFound;
                    }
                }
                if( currAmount < 0 || currTotal == 0 ) {
                    currAmount = 0;
                     $( '#expshowdeals').hide(); //junaid
                }else{
                    $( '#expshowdeals').show(); //junaid
                }
                if( amountFlag && amountChange ) {
                    $( '#show-total-amount h2 span' ).text( currAmount.toFixed(2) );
                    $( '#show-total-inr-amount h2 span' ).text( currINRAmount.toFixed(2) );
                    $( '#show-total-amount h2 span' ).text( $( '#show-total-amount h2 span' ).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
                    $( '#show-total-inr-amount h2 span' ).text( $( '#show-total-inr-amount h2 span' ).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
                    $( '#pe_checkbox_amount' ).val( currAmount.toFixed(2) );
                }
                //------------------------------junaid--------------------------------
                 
                if(currTotal >= total_invdeal && $('#hide_company_array').val()==''){
                    $('#export_checkbox_enable').val('');
                    $('#all_checkbox').prop('checked',true);
                    $('#all_checkbox').parents('.icheckbox_flat-red').addClass('checked');
                }else{
                    $('#all_checkbox').prop('checked',false);
                    $('#all_checkbox').parents('.icheckbox_flat-red').removeClass('checked');
                    
                }
               //--------------------------------------------------------------------------
                if( pehideFlag == 0 ) {
                    $( '.result-count .result-no span.res_total' ).text( currTotal );
                    $( '#total_inv_deal').val(currTotal); // junaid
                }
            }


            function updateCompanyCount( elementCompany, type, lastElement, pehideFlag,total_invcompany ) {
                var counts = {};
                var removedcompanyData = '';
                var companyData = $( '#pe_checkbox_company' ).val();
                if( type == 'remove' ) {
                    if( pehideFlag == 0 ) {
//                        if( lastElement ) {
//                            removedcompanyData = companyData.replace( elementCompany, '' );    
//                        } else {
//                            removedcompanyData = companyData.replace( elementCompany+',', '' );
//                        } 
        
                        removedcompanyData = companyData.replace( elementCompany, '' ); //replaced by jagadeesh
                        removedcompanyData = removedcompanyData.replace(/(^,)|(,$)/g, ""); //replaced by jagadeesh
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
                            counts[value] = 1;
                        } else {
                            counts[value]++;
                        }    
                    } 
                });
                $( '.result-count .result-no span.comp_total' ).text( Object.keys(counts).length ); 
                $( '#total_inv_company').val(Object.keys(counts).length); 
            }
      
       </script>

<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
<form id="other_db_submit" method="post">
                <input type="hidden" name="searchallfield_other" id="other_searchallfield" value="<?php echo $searchallfield;?>">
                <input type="hidden" name="companyauto_sug_other" id="companyauto_sug_other" value="<?php echo $companyauto;?>">
                <input type="hidden" name="companysearch_other" id="companysearch_other" value="<?php echo $company_filter;?>">
                <input type="hidden" name="investorauto_sug_other" id="investorauto_sug_other" value="<?php echo $investorauto;?>">
                <input type="hidden" name="keywordsearch_other" id="keywordsearch_other" value="<?php echo $invester_filter;?>">
                <input type="hidden" name="sectorsearch_other" id="sectorsearch_other" value="<?php echo $sectors_filter;?>">
                <input type="hidden" name="advisorsearch_legal_other" id="advisorsearch_legal_other" value="<?php echo $advisorsearchstring_legal;?>">
                <input type="hidden" name="advisorsearch_trans_other" id="advisorsearch_trans_other" value="<?php echo $advisorsearchstring_trans;?>">
                <input type="hidden" name="all_keyword_other" id="all_keyword_other" value="">
</form>
<!-- <div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div> -->
<!-- T960 start---------------------------------------------------------->
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 100% !important; display: none;"></div>
    <div class="lb" id="popup-box-copyrights" style="width:65% !important;left:20%;top:10%;">
    <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body">
        <h3  style="text-align: center;font-size:19px;">Select fields for excel file export</h3>
        <div class="row">
            <label style="font-weight: 600;"><input type="checkbox" class="allexportcheck" id="allexportcheck"/> Select All</label>
            <ul class="exportcolumn">
            <?php 
            if($VCFlagValueString == '0-1' || $VCFlagValueString == '0-2'){
            ?>
                <!-- <li><input type="checkbox" class="companyexportcheck" name="skills" value="PortfolioCompany" checked/> <span>Portfolio Company</span></li> -->
                <li><input type="checkbox" class="exportcheck" name="skills" value="PortfolioCompany"/> <span>Portfolio Company</span></li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="CIN"/><span>CIN</span></li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="YearFounded" /> Year Founded</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="ExitingInvestors" /> Exiting Investors</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="InvestorType" /> Investor Type</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="ExitStatus" /> Exit Status</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Industry" /> Industry</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="SectorBusinessDescription" /> Sector_Business Description</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="DealType" /> Deal Type</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Type" /> Type</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Acquirer" /> Acquirer</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="DealDate" /> Deal Date</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="DealAmount" /> Deal Amount (US\$M)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="AdvisorSeller" /> Advisor-Seller</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="AdvisorBuyer" /> Advisor-Buyer</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Website" /> Website</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="AddlnInfo" /> Addln Info</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="InvestmentDetails" /> Investment Details</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Link" /> Link</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="ReturnMultiple" /> ReturnMultiple</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="IRR" /> IRR (%)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="MoreInfo" /> More Info(Returns)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="CompanyValuation" /> Company Valuation (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="RevenueMultiple" /> Revenue Multiple</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDAMultiple" /> EBITDA Multiple</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="PATMultiple" /> PAT Multiple</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="PricetoBook" /> Price to Book</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Valuation" /> Valuation (More Info)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue" /> Revenue (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA" /> EBITDA (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="PAT" /> PAT (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="BookValuePerShare" /> Book Value Per Share</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="PricePerShare" /> Price Per Share</li>
                <!-- <li><input type="checkbox" class="exportcheck" name="skills" value="LinkforFinancials" /> Link for Financials</li> -->
            <?php } ?>
                
            </ul>
        </div>
        <div class="cr_entry" style="text-align:center;margin-top:25px;">
            <input type="button" value="Submit" id="agreebtn-filter" />
        </div>
   </div>
</div>

<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 100% !important; display: none;"></div>
<div class="lb" id="popup-box-copyrights-filter" style="width:650px !important;">
   <span id="expcancelbtn-filter" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
<!--End T960 ------------------------------------------------------------->

<script>     
                        
// $('#agreebtn').click(function(){ 
    
//     if($("#agreebtn").attr("data-export") == 'mandaexport'){
        
//         jQuery('#popup-box-copyrights').fadeOut();   
//         jQuery('#maskscreen').fadeOut();
//         jQuery('#preloading').fadeIn();   
//         initExport('exportmandadeals.php');
//         return false;
        
//     }else{
//         jQuery('#popup-box-copyrights').fadeOut();   
//         jQuery('#maskscreen').fadeOut();
//         jQuery('#preloading').fadeIn();   
//         initExport('exportmandaexit_invdeals.php');
//         return false; 
//     }
    
// });
// $('#expcancelbtn').click(function(){ 
    
//     jQuery('#popup-box-copyrights').fadeOut();   
//     jQuery('#maskscreen').fadeOut(1000);
//     return false;
// });

//T960 start ------------------------------------------------------------->
$(document).ready(function () {
    $('.exportcheck').iCheck('destroy');
    $('.allexportcheck').iCheck('destroy');
    $('.companyexportcheck').iCheck('destroy');
    $('.allexportcheck').iCheck('check');
    $(".resultarray").val('Select-All');
    $(document).on("click",".allexportcheck",function() {
        if ($(this).is(':checked')) {
            $('.exportcolumn .exportcheck').attr('checked', true);
            $('.exportcolumn .exportcheck').trigger('change');
        } else {
            $('.exportcolumn .exportcheck').attr('checked', false);
            $(".resultarray").val('');
        }
    });
    $(document).on("click",".companyexportcheck",function() {
        if ($(this).is(':checked')) {
            $('.exportcolumn .companyexportcheck').attr('checked', true);
            $('.exportcolumn .companyexportcheck').trigger('change');
        } else {
            $('.exportcolumn .companyexportcheck').attr('checked', true);
        }
    });
    
    $(document).on("change",".exportcheck",function() {
        var result = $('.exportcolumn input[type="checkbox"]:checked'); // this return collection of items checked
        var totalcheckbox = $('.exportcolumn input[type="checkbox"]');
        if (result.length > 0) {
            var resultString ="";
            result.each(function () {
                resultString += $(this).val() + "," ;
                // resultString+= $(this).val() + "<br/>";
            });
            resultString =  resultString.replace(/,\s*$/, "");
			$(".resultarray").val(resultString);
        }
        if(result.length==totalcheckbox.length)
        {
            $('.allexportcheck').attr('checked', true);
        }
        else{
            $('.allexportcheck').attr('checked', false);
        }
    });
});
// T960 end ------------------------------------------------------------->

// T960 Start ----------------------------------------------------------->
$(document).on('click','#agreebtn-filter',function(){
    // alert($("#agreebtn").attr("data-export"));

    if($("#agreebtn").attr("data-export") == 'mandaexport'){
        if($('.exportcheck:checked').length == 0){
            alert('Please select minimum one field');
            return false;
        }
        jQuery('#popup-box-copyrights').fadeOut();   
        // jQuery('#maskscreen').fadeIn();
        // jQuery('#preloading').fadeIn();  
        $('#popup-box-copyrights-filter').fadeIn(); 
        
    }else{
        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut();
        jQuery('#preloading').fadeIn(); 
        $('#popup-box-copyrights-filter').fadeIn();  
    }
 
        
    });
    $(document).on('click','#expcancelbtn-filter',function(){

        jQuery('#popup-box-copyrights-filter').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        $('#preloading').fadeOut();
        return false;
    });
    
                     
$('#agreebtn').click(function(){
    
    if($("#agreebtn").attr("data-export") == 'mandaexport'){
    
        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#popup-box-copyrights-filter').fadeOut(1000);   
        jQuery('#maskscreen').fadeOut();
        jQuery('#preloading').fadeIn(2000);   
        initExport('exportmandadeals.php');
        return false;
        
    }else{
        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut();
        jQuery('#preloading').fadeIn();   
        initExport('exportmandaexit_invdeals.php');
        return false; 
    }
    
});
$('#expcancelbtn').click(function(){ 
    
    jQuery('#popup-box-copyrights').fadeOut();   
    jQuery('#maskscreen').fadeOut(1000);
    return false;
});
// T960 End ------------------------------------------------------------>

</script>       
       
</body></html><?php
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
<?php 
//ech
//if($type==1 && $vcflagValue==0)
 if($type==1 && $hide_pms==1)
{ 
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
                $("#exporttrend").click(function(){
                
                    $("#exporttable").submit();
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
            var query_string = 'value=4&y='+topping;
             <?php if($drilldownflag==1){ ?>
              window.location.href = 'mandaindex.php?'+query_string;
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
                    //colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  });
             
             //Fill table
             var pintblcnt = '';
             var tblCont = '';
                         
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
             //pintblcnt = pintblcnt + '</thead>';
             //pintblcnt = pintblcnt + '<tbody>';
             
             tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
             tblCont = tblCont + '';
             tblCont = tblCont + '';
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
             tblCont = tblCont + '';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
             
             //updateTables();
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
<?php
    }
//else if($type==1 && $vcflagValue==1)
else if($type==1 && $vcflagValue==0)
{ ?>
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
                $("#exporttrend").click(function(){
                
                    $("#exporttable").submit();
                });
    });
    </script>
<script type="text/javascript">
      function drawVisualization(dealdata) 
      {
        var data = new google.visualization.DataTable();
        data.addColumn('string','Year');
        data.addColumn('number', 'No of Deals');
        data.addColumn('number', 'Amount($m)');
        data.addRows(dealdata.length);
        for (var i=0; i< dealdata.length ;i++)
                {
            for(var j=0; j< dealdata[i].length ;j++)
                        {
                if (j!=0)
                    data.setValue(i, j,Math.round(dealdata[i][j]-0));
                else
                    data.setValue(i, j,dealdata[i][j]);
            }           
        }
        // Create and draw the visualization.
        var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
        divwidth=  document.getElementById("visualization2").offsetWidth;
        divheight=  document.getElementById("visualization2").offsetHight;
          
       function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=3&y='+topping;
             <?php if($drilldownflag==1){ ?>              window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
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
                  //  colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  });
              
            //Fill table
             var pintblcnt = '';
             var tblCont = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
             
             tblCont = '';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
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
//           tblCont = tblCont + '<tbody>';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
      }
      
    </script>
<?php
        
    }
//else if($type==1 && $vcflagValue==3) //Not used
 else if($type==1 && $vcflagValue==1)
{ ?>
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
        divwidth=  document.getElementById("visualization2").offsetWidth;
        divheight=  document.getElementById("visualization2").offsetHight;
          
       function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
         if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=4&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
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
                  //  colors: ["#FCCB05","#a2753a"],
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
             
             tblCont = '';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
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
             tblCont = tblCont + '';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
<?php
        
    }
//else if($type==2 && $vcflagValue==0) 
 else if($type==2 && $hide_pms==1)
{  //  print_r($deal);   ?>
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
                
                $("#exporttrend").click(function(){
                
                    $("#exporttable").submit();
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
                     window.location.href = 'mandaindex.php?'+query_string;
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
                 /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
                 window.location.href = 'mandaindex.php?'+query_string;
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
                    // colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46","#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
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
              draw(data3, {title:"No of Deals",
              /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
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
              draw(data4, {title:"Amount",
               /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

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
<?php 
     }
//else if($type==2 && $vcflagValue==1)
 else if($type==2 && $vcflagValue==0)
{
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
                $("#exporttrend").click(function(){
                
                    $("#exporttable").submit();
                });
            });
        </script>
<script type="text/javascript">
            //Graph 1
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
                     window.location.href = 'mandaindex.php?'+query_string;
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
                /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
                 window.location.href = 'mandaindex.php?'+query_string;
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
                    /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46","#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"No of Deals",
              /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
    
            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount",
               /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

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
<?php 
     }
//else if($type==2 && $vcflagValue==3) //not used
else if($type==2 && $vcflagValue==1)
{
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
            //Graph 1
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
                     window.location.href = 'mandaindex.php?'+query_string;
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
                 /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
                isStacked : true
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
                 window.location.href = 'mandaindex.php?'+query_string;
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
                     /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46","#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"No of Deals",
              /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
    
            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount",
              /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
             
             tblCont = '';
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
              
             
             tblCont = tblCont + '';
             tblCont = tblCont + '';
             
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
             tblCont = tblCont + '';

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
<?php 
     }
else if($type==3 && $vcflagValue==4) // Not used
{
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
                var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);
                
                //get totlal deal count of the year
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        totalDeals += datayear[j][arrhead[i]]; 
                }
                
                for (var i=1;i<arrhead.length;i++){                 
                    if (datayear[j][arrhead[i]]){
                        //alert((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);
                        arrval.push((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);                 
                    }else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            
            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);               
                        
                        
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if($drilldownflag==1){ ?>
             window.location.href = 'mandaindex.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
                isStacked : true
              }
          );
          
            //Garaph 2
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
                var totalamt = 0;
                var arrval = [];
                arrval.push(Years[j]);
                
                //get totlal deal amount of the year
                for (var i=1;i<arrhead.length;i++){
                    if(datayear[j][arrhead[i]])
                        totalamt += datayear[j][arrhead[i]]; 
                }
                
                for (var i=1;i<arrhead.length;i++){
                                        
                    if (datayear[j][arrhead[i]]){
                        arrval.push((((datayear[j][arrhead[i]]/totalamt)*100).toFixed(2))-0); }
                    else
                        arrval.push(0)
                }
                               
                dataArray.push(arrval); 
            }
            
            //Graph 1
            var data = google.visualization.arrayToDataTable(dataArray);    
             var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
              var selectedItem = chart5.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var stage = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);
               
               var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
                 <?php if($drilldownflag==1){ ?>
                 window.location.href = 'mandaindex.php?'+query_string;
                <?php } ?>
              }
            }
             google.visualization.events.addListener(chart5, 'select', selectHandler2);
             chart5.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                 /*  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"No of Deal",
     /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
              
              
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

            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
             // Create and draw the visualization.
            var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
            chart.draw(data4, {title:"Amount"/*,colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            google.visualization.events.addListener(chart, 'select', function() {
                var selection = chart.getSelection();
                console.log(selection);  
            }); 
            
            
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">STAGE</th><tr>';
             
             tblCont = '';
             tblCont = tblCont + '<tr><th style="text-align:center">STAGE</th>';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
        }
    </script>
<?php 
     }
else if($type==3 && $vcflagValue==5) // Not used
{
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
                var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);
                
                //get totlal deal count of the year
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        totalDeals += datayear[j][arrhead[i]]; 
                }
                
                for (var i=1;i<arrhead.length;i++){                 
                    if (datayear[j][arrhead[i]]!=null && datayear[j][arrhead[i]]!="")
                        arrval.push((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);                 
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);               
                        
                        
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if($drilldownflag==1){ ?>
             window.location.href = 'mandaindex.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
                isStacked : true
              }
          );
          
            //Garaph 2
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
                var totalamt = 0;
                var arrval = [];
                arrval.push(Years[j]);
                
                //get totlal deal amount of the year
                for (var i=1;i<arrhead.length;i++){
                    if(datayear[j][arrhead[i]])
                        totalamt += datayear[j][arrhead[i]]; 
                }
                
                for (var i=1;i<arrhead.length;i++){                 
                    if (datayear[j][arrhead[i]])
                        arrval.push((((datayear[j][arrhead[i]]/totalamt)*100).toFixed(2))-0);                   
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            //Graph 1
            var data = google.visualization.arrayToDataTable(dataArray);    
             var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
              var selectedItem = chart5.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var stage = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);
               
               var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
                 <?php if($drilldownflag==1){ ?>
                 window.location.href = 'mandaindex.php?'+query_string;
                <?php } ?>
              }
            }
             google.visualization.events.addListener(chart5, 'select', selectHandler2);
             chart5.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                   /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"No of Deal"/*,
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
              
              
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
             // Create and draw the visualization.
            var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
            chart.draw(data4, {title:"Amount" /*,colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            google.visualization.events.addListener(chart, 'select', function() {
                var selection = chart.getSelection();
                console.log(selection);  
            }); 
            
            
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">STAGE</th><tr>';
             
             tblCont = '';
             tblCont = tblCont + '<tr><th style="text-align:center">STAGE</th>';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
        }
    </script>
<?php 
     }
else if($type==3 && $vcflagValue==3) //Not Used
{
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
                var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);
                
                //get totlal deal count of the year
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        totalDeals += datayear[j][arrhead[i]]; 
                }
                
                for (var i=1;i<arrhead.length;i++){                 
                    if (datayear[j][arrhead[i]])
                        arrval.push((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);                 
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);               
                        
                        
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if($drilldownflag==1){ ?>
             window.location.href = 'mandaindex.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
                isStacked : true
              }
          );
          
            //Garaph 2
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
                var totalamt = 0;
                var arrval = [];
                arrval.push(Years[j]);
                
                //get totlal deal amount of the year
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        totalamt += datayear[j][arrhead[i]]; 
                }
                
                for (var i=1;i<arrhead.length;i++){                 
                    if (datayear[j][arrhead[i]])
                        arrval.push((((datayear[j][arrhead[i]]/totalamt)*100).toFixed(2))-0);                   
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval); 
            }
            
            //Graph 1
            var data = google.visualization.arrayToDataTable(dataArray);    
             var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
              var selectedItem = chart5.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var stage = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);
               
               var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
                 <?php if($drilldownflag==1){ ?>
                 window.location.href = 'mandaindex.php?'+query_string;
                <?php } ?>
              }
            }
             google.visualization.events.addListener(chart5, 'select', selectHandler2);
             chart5.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                   /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"No of Deal"/*,
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
              
              
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
             // Create and draw the visualization.
            var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
            chart.draw(data4, {title:"Amount"/*,colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            google.visualization.events.addListener(chart, 'select', function() {
                var selection = chart.getSelection();
                console.log(selection);  
            }); 
            
            
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">STAGE</th><tr>';
             
             tblCont = '';
             tblCont = tblCont + '<tr><th style="text-align:center">STAGE</th>';
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
              
//           
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
        }
    </script>
<?php 
     }
//else if($type==4 && $vcflagValue==0)
 else if($type == 4 && $hide_pms==1)
{
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
                        $("#exporttrend").click(function(){
                
                            $("#exporttable").submit();
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart7, 'select', selectHandler2);
              chart7.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
                  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
            
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
            
            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization3')).
                  draw(data4, {title:"Amount"/*,
                  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
            
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
            
             
             tblCont = tblCont + '';
             pintblcnt = pintblcnt + '</table>';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
    
        }
    </script>
<?php 
     }
//else if($type==4 && $vcflagValue==1) 
else if($type == 4 && $vcflagValue==0)
{   ?>
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
                        $("#exporttrend").click(function(){
                
                            $("#exporttable").submit();
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart7, 'select', selectHandler2);
              chart7.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
                  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
            
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
            
            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization3')).
                  draw(data4, {title:"Amount"/*,
                  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
        
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
             
             tblCont = '';
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
              
             
             tblCont = tblCont + '';
             tblCont = tblCont + '';
             
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
                
                //console.log(dataArray[arrhead[i]]);
            }
            
             
             tblCont = tblCont + '';
             pintblcnt = pintblcnt + '</table>';
             
             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
            
              
        }
    </script>
<?php 
     }
//else if($type==4 && $vcflagValue==3) // Not used
 else  if($type == 4 && $vcflagValue==1)
{   ?>
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart7, 'select', selectHandler2);
              chart7.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
                  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
            
            
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
            
            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization3')).
                  draw(data4, {title:"Amount"/*,
                  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
            "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
            
        
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
                
                //console.log(dataArray[arrhead[i]]);
            }
            
             
             tblCont = tblCont + '';
             pintblcnt = pintblcnt + '</table>';
             
             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
            
              
        }
    </script>
<?php 
     }
//else if($type==5 && $vcflagValue==0)  
else if($type==5 && $hide_pms==1)
{   ?>
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
                        $("#exporttrend").click(function(){
                
                            $("#exporttable").submit();
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"By Deals"/*,
              colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
        
        
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
        
        console.log(dataArray);
        console.log(dealdata);
        
        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);          
        }
    // Create and draw the visualization.
      new google.visualization.PieChart(document.getElementById('visualization3')).
          draw(data4, {title:"Amount"/*,
          colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
          
          
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
            
          
        }
        
        </script>
<?php 
     }
    
else if($type==5 && $vcflagValue==0)
{
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
                    $("#exporttrend").click(function(){
                
                        $("#exporttable").submit();
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Type",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Type"},
               /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"By Deals"/*,
              colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"*/});
        
        
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
        
        console.log(dataArray);
        console.log(dealdata);
        
        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);          
        }
    // Create and draw the visualization.
      new google.visualization.PieChart(document.getElementById('visualization3')).
          draw(data4, {title:"Amount"/*,
          colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
          
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
        }
        
        </script>
<?php 
     }
//else if($type==5 && $vcflagValue==3) // Not used
else if($type==5 && $vcflagValue==1)
{
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
              /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
        
        
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
        
        console.log(dataArray);
        console.log(dealdata);
        
        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);          
        }
    // Create and draw the visualization.
      new google.visualization.PieChart(document.getElementById('visualization3')).
          draw(data4, {title:"Amount"/*,
          colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
          
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
        }
        
        </script>
<?php 
     }
else if($type==6 && $vcflagValue==4)  // Not used
{    
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
              /*  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"No of Deals"/*,colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
        
        
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
        
        console.log(dataArray);
        console.log(dealdata);
        
        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);          
        }
        
        // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount"/*,
              colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
          
          
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
          
        }
      </script>
<?php } 
else if($type==6 && $vcflagValue==5)  // Not used
{  ?>
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"No of Deals"/*,colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
        
        
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
        
        console.log(dataArray);
        console.log(dealdata);
        
        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);          
        }
        
        // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount"/*,
              colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
          
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
        }
      </script>
<?php 
     }
else if($type==6 && $vcflagValue==3) // Not used
{  ?>
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
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
              draw(data3, {title:"No of Deals"/*,colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
        
        
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
        
        console.log(dataArray);
        console.log(dealdata);
        
        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);          
        }
        
        // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount"/*,
              colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
        "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
          
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';
             
             tblCont = '';
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
              
             
//           tblCont = tblCont + '</thead>';
//           tblCont = tblCont + '<tbody>';
             
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
             tblCont = tblCont + '';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
        }
      </script>
<?php 
     }
if($type == 14 && $vcflagValue==0 && $_POST)
{
    ?>
<script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
            <?php if($drilldownflag==1){ ?>
             window.location.href = 'mandaindex.php?'+query_string;
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
               /* colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals"/*,
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount"/*,
     colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
<?php 
    }
    else if($type == 14 && $vcflagValue==1 && $_POST)
    {
        ?>
<script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'mandaindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],*/
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals"/*,
      /*colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount"/*,
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]*/});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
<?php 
    }
    ?>
<?php
    if($_GET['type']!="")
    { ?>
<script language="javascript">
                    $(document).ready(function(){
                        setTimeout(function (){
                          $( "#ldtrend" ).trigger( "click" );
                        },1000);

                    });
            </script>
<?php }?>
<script type="text/javascript" >
                                    
                                
                                    
           $(".btn-slide").click(function(){
            $("#panel").animate({width: 'toggle'}, 200); 
            $(this).toggleClass("active"); 

            if ($('.left-td-bg').css("min-width") == '264px') {
            $('.left-td-bg').css("min-width", '36px');
            $('.acc_main').css("width", '35px');
            }
            else {
            $('.left-td-bg').css("min-width", '264px');
            $('.acc_main').css("width", '264px');
            } 
            
            
             ///// tour 
                
                 if(EXITSdemotour==1 )
                    {
                      $(".hopscotch-bubble").removeClass("tourboxshake");
                      $(".hopscotch-bubble").hide();
                      $('body').animate({scrollTop:0},500);  
                    
                   if(EXITSdemotour==1){ setTimeout(function() { $(".hopscotch-bubble").show(); hopscotch.startTour(tour, 3); },1000); }
                     
                    $("#acc_main").animate({ scrollTop: $("#acc_main").height() }, 3000);  

                    var autoscroll = setTimeout(function() {                        
                       $('#acc_main').animate({scrollTop:0},3000);
                       $('body').animate({scrollTop:0}, 1000); 
//                       $('#firstrefine').show(); 
                    },3000);
                    
                    
                   var closefrefine = setTimeout(function() {
                       // clearTimeout(autoscroll);
                       //$( "#firstrefine" ).toggle(2000); 
                       $( "#firstrefine" ).animate({ "height": "0px" },2000);
                    },3000);
                    
                    
                   var openfrefine =  setTimeout(function() { 
                        // clearTimeout(closefrefine);
                        $( "#firstrefine" ).animate({ "height": "400px" },2000);
                      // $( "#firstrefine" ).toggle(2000);
                    },7000);
                    
                    
                    var intervel = setTimeout(function(){                        
                     
                    // clearTimeout(openfrefine);
                    // auto open    
                 
                    
               
                    
                    /* select box click - trigger 
                      function open(elem) {
                        if (document.createEvent) {
                            var e = document.createEvent("MouseEvents");
                            e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                            elem[0].dispatchEvent(e);
                        } else if (element.fireEvent) {
                            elem[0].fireEvent("onmousedown");
                        }
                    }
                     open($('#sltindustry'));
                    */
                   

                  
                    var index = 0;                   
                    var type_this='5';
                    window.txtmultipleReturnfrom = function() {                       
                        if (index <= type_this.length) {                           
                            var txtmultipleReturnFrom = document.getElementById('txtmultipleReturnFrom');    
                            txtmultipleReturnFrom.value = type_this.substr(0, index++);                            
                            setTimeout("txtmultipleReturnfrom()", 200);
                        }
                    }
                    
                   
                    
                    var index2 = 0; 
                    var type_this2='100';
                    window.txtmultipleReturnto = function() {                       
                        if (index2 <= type_this2.length) {                           
                            var txtmultipleReturnTo = document.getElementById('txtmultipleReturnTo');    
                            txtmultipleReturnTo.value = type_this2.substr(0, index2++);                            
                            setTimeout("txtmultipleReturnto()", 200);
                        }
                    }
                   

                    
                    var a = setTimeout(function(){  if(EXITSdemotour==1){  $("#sltindustry").attr('size', 5).fadeIn(); } },2000);
                    var b = setTimeout(function(){  if(EXITSdemotour==1){  $("#sltindustry").removeAttr('size');  $("#dealtype").attr('size', 5).fadeIn();   } },4000);
                    var c = setTimeout(function(){  if(EXITSdemotour==1){  $("#dealtype").removeAttr('size');    $("#invType").attr('size', 2).fadeIn();    } },6000);
                    var d = setTimeout(function(){  if(EXITSdemotour==1){  $("#invType").removeAttr('size');   $("#exitstatus").attr('size', 2).fadeIn();   } },8000);
                    var e = setTimeout(function(){  if(EXITSdemotour==1){  $("#exitstatus").removeAttr('size');    txtmultipleReturnfrom('5');    } },10000);
                    var f = setTimeout(function(){  if(EXITSdemotour==1){  txtmultipleReturnto('20');    } },11000);
                    var g = setTimeout(function(){  if(EXITSdemotour==1){  $("#txtmultipleReturnFrom").val(''); $("#txtmultipleReturnTo").val('');   } },12000);
                    var h = setTimeout(function(){  if(EXITSdemotour==1){   hopscotch.startTour(tour, 4);  } },13000);
                    // end auto open
                    
                                             
                    },8000);
                    
                    }
            
            return false; //Prevent the browser jump to the link anchor
            });                          
             
           
        
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
/*T960 start */
#maskscreen{
     height: 100% !important;
 }
 ul.exportcolumn {
    -webkit-column-count: 4;
    -moz-column-count: 4;
    column-count: 4;
}
.exportcolumn li,.copyright-body label{
    line-height:35px;
}
    /*T960 end */
        .other_db_search{
            display: none;            
            width: 100%;
            float: left;
            margin-bottom: 50px;
        }                                
        .other_db_searchresult a{
            margin-left: 5px;
        }
        .other_db_searchresult{
            background: #F2EDE1;
            padding: 10px;
            margin: 0 17px;
            font-weight: bold;
            font-size: 12px;
                                
        }
        .other_loading{
            margin: 0;
            text-align: center;
            font-weight: bold;
        }
        .other_db_link{
            background: #a2753a;
            padding: 2px 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 2px;
        }
         .other_db_link:hover{
            background:#413529;
            color: #fff;
        }
        .other_db_links{
            background: #a2753a;
            padding: 2px 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 2px;
        }
         .other_db_links:hover{
            background:#413529;
            color: #fff;
        }
    </style>
<script>
    <?php 
    
      if($VCFlagValueString == '0-0') 
                {
                    $section="PE-Exits-MA";
                }
                else if($VCFlagValueString == '0-1')
                {
                     $section="PE-Exits-PublicMarket";
                }
                 else if($VCFlagValueString == '1-0')
                {
                     $section="VC-Exits-MA";
                }
                else if($VCFlagValueString == '1-1')
                {
                     $section="VC-Exits-PublicMarket";
                }
                else if($VCFlagValueString == '0-2')
                {
                    $section="PE-Exits-MA";
                }
    
    if($searchallfield !=''){ ?>
        $(document).ready(function(){
            
            <?php if ($company_cnt==0){ ?>
                              $('.other_db_search').css('margin-top','150px');
            <?php } ?>
                
            $('.other_db_search').fadeIn();            
           $.get( "gmail_like_search.php?section=<?php echo $section;?>&search=<?php echo $searchallfield;?>", function( data ) {          
           
            var data = jQuery.parseJSON(data);
            console.log(data);
            
            var html='';            
            html += data.message+' ';
            
            if(data.result ==1){
                 var count=1;
                 $.each( data.sections, function( key, value ) {                   
                        //if(count>1){html +=',';}
                        html += value.html; 
                   count++;
                  });                  
                  //html +='.';
                  $('.other_db_searchresult').html(html);
                  $('.other_db_search').fadeIn();
            }else{
                 $('.other_db_searchresult').html('<p class="other_loading">No matching results found in other database.</p>');
                 $('.other_db_search').fadeOut(10000);
            }            
            
          });
          
          
           $(".other_db_link").live( "click", function() {
              var href = $(this).attr('href');
              $('#other_db_submit').attr('action',href);
              $('#other_db_submit').submit();
              
               return false;
           });
          
          
        });
    <?php } ?>




 $(document).ready(function(){
 <?php if(  $combineSearchFlag || ( trim($invester_filter)!='' || trim($acquirerauto)!='' || trim($companyauto)!='' ||  trim($sectorsearch)!='' ||  trim($advisorsearchstring_legal)!='' ||  trim($advisorsearchstring_trans)!='' )){
     
     $searchList=$invester_filter.$acquirerauto.$companyauto.str_replace("'","",trim($sectorsearch)).$advisorsearchstring_legal.$advisorsearchstring_trans;
     $searchList = explode(',', $searchList);
     $count=0;
     // if($invester_filter !=''){
     //     $filed_name = 'investor';
     // }else if($companyauto !=''){
     //     $filed_name = 'company';
     // }else if($sectorsearch !=''){
     //     $filed_name = 'sector';
     // }else if($advisorsearchstring_legal !=''){
     //     $filed_name = 'alegal';
     // }else if($advisorsearchstring_trans !=''){
     //     $filed_name = 'atrans';
     // }
      if($advisorsearchstring_legal !=''){
         $filed_name = 'alegal';
     }else if($advisorsearchstring_trans !=''){
         $filed_name = 'atrans';
     }else if($combineSearchFlag !=''){
        $searchStringGmail = "&industry=".implode(",",$industry)."&sector=".implode(",",$sector)."&subsector=".$subsectorString."&keyword=".$investorsearch."&companysearch=".$companysearch."&dealtype=".$dealtype."&investorType=".$investorType."&exitstatusValue=".implode(",",$exitstatusValue);
         $filed_name = 'combinesearch';
     }
     ?>    
                                             
       $('.other_db_search').css('margin-top','50px');                                      
       $('.other_db_search').fadeIn();   
       $('.other_db_searchresult').html('');
       var href='';
       var filed_name='';
       filed_name = <?php echo "'".$filed_name."'"; ?>;

     <?php 
     if( $filed_name == 'company' ) {
        $svCompanyName = explode( ',', $company_filter );
     }  ?>

     $('.other_db_search').fadeIn();
           $.get( "gmail_like_search.php?section=<?php echo $section; ?>&search=<?php echo $searchallfield; ?><?php echo $searchStringGmail; ?>&filed_name="+filed_name, function( data ) {
            var data = jQuery.parseJSON(data);
            console.log(data);
            var html='';
            html += data.message+' ';
            if(data.result ==1){
                 var count=1;
                 $.each( data.sections, function( key, value ) {
                        //if(count>1){html +=',';}
                        html += value.html;
                   count++;
                  });
                  //html +='.';
                  $('.other_db_searchresult').html(html);
                  $('.other_db_search').fadeIn();
            }else{
                 $('.other_db_searchresult').html('<p class="other_loading">No matching results found in other database.</p>');
                 $('.other_db_search').fadeOut(10000);
            }
          });
    <?php
     foreach ($searchList as $searchtext) {
         if( $filed_name == 'company' ) {
            $searchallfield = trim($searchtext);
            $searchallfieldName = trim( $svCompanyName[ $count ] );
        } else {
            $searchallfield = trim($searchtext);
            $searchallfieldName = trim($searchtext);
        }
     
         $count++;
  ?>    
       console.log('<?php echo $searchallfield;?>');                                   
       // var link ="gmail_like_search.php?section=<?php echo $section;?>-not&search=<?php echo$searchallfield;?>&filed_name=<?php echo $filed_name; ?>";                                   
       // var text = 'Click here to search';  
       
       //  href += '<div class="refine_to_global"> "<?php echo $searchallfieldName?>"<a class="refine_to_global_link"  href="'+link+'" id="refinesearch_<?php echo$count?>" >'+text+'</a><div class="other_db_searchresult refinesearch_<?php echo$count?>"></div><div>';
     
 <?php } ?> 

  $('.other_db_searchresult').html('<b style="font-size:14px">Search in other databases</b><br><br>'+href);
  
   $(".refine_to_global_link").click(function() {
       var getLink = $(this).attr('href');
       var classname = this.id;
       
       $('.'+classname).html('<p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>');
        
      // alert(getLink);
       
       $.get(getLink, function( data ) {          
           
            var data = jQuery.parseJSON(data);
            console.log(data);
            
            var html='';            
            html += data.message+' ';
            
            if(data.result ==1){
                 var count=1;
                 $.each( data.sections, function( key, value ) {                   
                        //if(count>1){html +=',';}
                        html += value.html; 
                   count++;
                  });                  
                  //html +='.';
                  $('.'+classname).html(html);
                  $('.other_db_search').fadeIn();
            }else{
                 $('.'+classname).html('<p class="other_loading">No matching results found in other database.</p>');
                 //$('.other_db_search').fadeOut(10000);
            }            
            
          });
          
       return false;
   });
  
  
    $(".other_db_link").live( "click", function() {
    
              var href = $(this).attr('href');
              var searchValue = $(this).attr('data-value');
              
              $('#other_searchallfield').val(searchValue);
              $('#other_db_submit').attr('action',href);
              $('#other_db_submit').submit();
              
               return false;
           });
  
 <?php    } ?>
  });
  
  
  
    </script>
<?php if(isset($_SESSION['currenttour'])) { echo ' <script src="'.$_SESSION['currenttour'].'.js?16feb"></script> '; } ?>
<script src="TourStart.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
// Tag Search
var tagsearchval = $('#tagsearch').val();
if(tagsearchval == ''){
    $('.acc_trigger.helptag').removeClass('active').next().hide();
}
// Tag search
   <?php if(isset($_SESSION["EXITSdemoTour"]) && $_SESSION["EXITSdemoTour"]=='1') { ?>
        EXITSdemotour=1;

         <?php if($_POST["searchallfield"]=='Justdial' || $_POST["searchallfield"]=='justdial'){?>
               hopscotch.startTour(tour, 18);                                   
         <?php }
         else if($_POST["month1"]=='7' && $_POST["month2"]=='9' && $_POST["year1"]=='2014' && $_POST["year2"]=='2014') {?>
               $('body,html').animate({ scrollTop: $(document).height()  }, 6000);    
               setTimeout(function() {
                                if(EXITSdemotour==1){hopscotch.startTour(tour, 15);  }                                  
                            },3000);
         <?php }
         else if($_GET["value"]=='0-1'){?>
               hopscotch.startTour(tour, 14);                                   
         <?php }
         else if( ( $_POST["month1"]=='4' && $_POST["month2"]=='6' && $_POST["year1"]=='2013' && $_POST["year2"]=='2013' && $_POST['tourlistview']=='startstep14') || $_POST['tourlistview']=='startstep14' ){?>                                               
               hopscotch.startTour(tour, 13);                   
         <?php }
         else if($_POST["month1"]=='4' && $_POST["month2"]=='6' && $_POST["year1"]=='2013' && $_POST["year2"]=='2013') {?>                                               
               hopscotch.startTour(tour, 6);                   
         <?php }
         else if(isset($_POST["industry"]) && ($_POST["industry"]=='1') ){?>
               hopscotch.startTour(tour, 5);                   
         <?php }
         else { ?>
                hopscotch.startTour(tour,0); 
            <?php } ?>  

  <?php } ?>


$(".other_db_search").on('click', '.other_db_link', function() {

        var search_val = $(this).attr('data-search_val');
        $('#all_keyword_other').val(search_val);
       });
   });

   $(document).ready(function () {
    
    $('#popup_keyword').keyup(function() {
        var $th = $(this);
        var popup_select =$('#popup_select').val();
        if(popup_select == "" || popup_select == "exact")
        {
            $th.val( $th.val().replace(/[^a-zA-Z0-9_ _ &.']/g, function(str) { alert('You typed ' + str + ' \n\nPlease use only letters, space and numbers.'); return ''; } ) );
        }
    });
});
</script>
<?php
mysql_close();
    mysql_close($cnx);
    ?>
