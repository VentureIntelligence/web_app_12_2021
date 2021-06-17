<?php include_once("../globalconfig.php"); ?>
<?php   
//other database
    /*$all_keyword_other = trim($_POST['all_keyword_other']);
    $searchallfield_other = $_POST['searchallfield_other'];
    $investorauto_sug_other = $_POST['investorauto_sug_other'];
    $keywordsearch_other = $_POST['keywordsearch_other'];
    $companyauto_other =$_POST['companyauto_other'];
    $companysearch_other =$_POST['companysearch_other'];
    $sectorsearch_other =$_POST['sectorsearch_other'];*/
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';
    $tagandor=$_POST['tagandor'];
    $tagradio=$_POST['tagradio'];
    if($_POST['tagsearch'] != "" || $_POST['tagsearch_auto'] != ""){
        $_POST['investorauto_sug']="";
        $_POST['searchallfield'] = "";
        $_POST['companysearch'] = "";
        $_POST['companyauto']="";
        $_POST['industry']="";
        $_POST['invType']="";
        $_POST['invSale']="";
        $_POST['exitstatus']="";
        $_POST['txtmultipleReturnFrom']="";
        $_POST['txtmultipleReturnTo']="";
        $_POST['yearafter']="";
        $_POST['yearbefore']="";
        $_POST['invhead']="";
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
    if(isset($all_keyword_other) && $all_keyword_other !=''){
        if(isset($keywordsearch_other) && $keywordsearch_other !=''){
            $ex_keywordsearch_other = explode(',', $keywordsearch_other);
            $ex_investorauto_sug_other = explode(',', $investorauto_sug_other);
            if(!in_array($all_keyword_other, $ex_keywordsearch_other)){
                $_POST['keywordsearch_other'] ='';
                $_POST['investorauto_sug_other'] = '';
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
        else if(isset($searchallfield_other) && $searchallfield_other !=''){
            $ex_searchallfield_other = explode(',', $searchallfield_other);
        }else if(isset($sectorsearch_other) && $sectorsearch_other !=''){
            $ex_sectorsearch_other = explode(',', $sectorsearch_other);
            if(in_array($all_keyword_other, $ex_sectorsearch_other)){
                $_POST['searchallfield_other'] = $all_keyword_other;
            } 
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
        $companyIdSGR=390958295;//688981071;//
        $companyIdVA=38248720;
        $companyIdGlobal=730002984;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : 0;
        $VCFlagValue=$vcflagValue;
        if($vcflagValue==0)
        {$videalPageName="PEIpo";}
        else {$videalPageName="VCIpo";}
        include ('checklogin.php');
       
        
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
        $buttonClicked=$_POST['hiddenbutton'];
        $fetchRecords=true;
        $totalDisplay="";
//print_r($_POST);
        $resetfield=$_POST['resetfield'];
        $getyear = $_REQUEST['y'];
        $getindus = $_REQUEST['i'];
        $getstage = $_REQUEST['s'];
        $getinv = $_REQUEST['inv'];
        $getreg = $_REQUEST['reg'];
        $getrg = $_REQUEST['rg'];
        
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
                $month1= date('n');
                $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                $month2= date('n');
                $year2 = date('Y');
                $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=date("Y");
                $endyear = date("Y-m-d");
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
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
            }elseif (($resetfield=="searchallfield")||($resetfield=="companysearch"))
            {
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
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['investorauto_sug'])!=""  || trim($_POST['companysearch'])!="")
            {
                if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                $month1=01; 
                               $year1 = 2000;
                $month2= date('n');
                $year2 = date('Y');
                       }else if(isset($_POST['month1']) || isset($_POST['year1']) || isset($_POST['month2']) || isset($_POST['year2'])){
                               $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                               $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                               $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                               $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                      }else{
                               $month1=01; 
                               $year1 = 2000;
                               $month2= date('n');
                               $year2 = date('Y');
               }
            }elseif ( (count($_POST['industry']) > 0) || ($_POST['invSale']!="--")  || ($_POST['invType']!="--") || ($_POST['exitstatus']!="--")
                || ($_POST['txtmultipleReturnFrom']!="") || ($_POST['txtmultipleReturnTo']!="") || $_POST['tagsearch']!='' || $_POST['tagsearch_auto']!='' || $_POST['invhead'] != '')
            {
                if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                        
                        
                    $month1=01; 
                    $year1 = 2000;
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
            $endyear =  $fixend."-".$month2."-31";
            
        }
        
        
//        if($resetfield=="investorsearch")
//        { 
//         $_POST['investorsearch']="";
//         $keyword="";
//         $keywordhidden="";
//          $investorauto='';
//        }
//        else 
//        {
//         $keyword=trim($_POST['investorsearch']);
//         $keywordhidden=trim($_POST['investorsearch']);
//         if($keyword!=''){
//                $searchallfield='';
//        }
//            $investorauto=$_REQUEST['investorauto'];
//        }
//        $keywordhidden =ereg_replace(" ","_",$keywordhidden);
//        //echo $keyword
        
        if($resetfield=="refcloseall")
        { 
            $_POST['investments'] = "";
            $_POST['industry'] = "--";
            $_POST['comptype'] = "--";
            $_POST['dealtype_debtequity'] ="--";
            $_POST['txtregion'] ="--";
            $_POST['invType'] ="--";
            $_POST['invhead'] ="--";
            $_POST['stage']="";
            $_POST['round']="--";
            $_POST['citysearch']="";
            $_POST['invrangestart'] ="--";
            $_POST['invrangeend'] = "--";
            $_POST['keywordsearch'] = ""; 
            $_POST['companysearch'] = ""; 
            $_POST['advisorsearch_trans'] = ""; 
        }
        
        if($resetfield=="searchallfield")
        { 
            $_POST['searchallfield']="";
            $_POST['searchKeywordLeft']="";
            $_POST['searchTagsField']="";
            $searchallfield="";
        }
        else 
        {
            if(isset($_POST['searchallfield']) && trim($_POST['searchallfield']) !=''){
                $searchallfield=trim($_POST['searchallfield']);
            }else if(isset($_POST['searchKeywordLeft']) && $_POST['searchKeywordLeft'] !=''){
               $searchallfield=trim($_POST['searchKeywordLeft']);             
            }else if($_POST['searchallfieldHide'] !=''){ 
                $searchallfield ='';
            }else if(isset($_POST['searchTagsField']) && trim($_POST['searchTagsField']) !=''){
                $searchallfield=trim($_POST['searchTagsField']);
            }else if($_POST['popup_select'] == 'tags' && $_POST['popup_keyword'] !=''){
                $searchallfield="tag:".trim($_POST['popup_keyword']);
            }else if($_POST['tagsearch'] && $_POST['tagsearch'] !=''){
                $searchallfield="tag:".trim($_POST['tagsearch']);
            }else if($_POST['popup_select'] == '' && $_POST['popup_keyword'] !=''){
                $searchallfield=trim($_POST['popup_keyword']);
            }
            if($searchallfield != "")
            {
                $_POST['keywordsearch']="";
                $_POST['investorauto_sug']="";
                $_POST['companysearch'] = ""; 
                $_POST['companyauto_sug']="";
                $_POST['tagsearch']="";
                $_POST['tagsearch_auto']="";
            }
        }
        $searchallfieldhidden=ereg_replace(" ","-",$searchallfield);
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
            if($yearafter !='' ||  $yearbefore !=''){
                $searchallfield='';
            }

        }
        if($resetfield=="investorsearch")
        { 
            // $_POST['investorauto_sug']="";
            // $keywordhidden="";
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

            $_POST['invSale']="--";
            $investorSale="--";
            $_POST['exitstatus']="--";
            $exitstatusvalue="--";

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
                $keyword1=trim($_POST['keywordsearch']);
            if(isset($_POST['investorauto_sug_other'])){
                $investorauto=$_POST['keywordsearch_other'];
                $keyword=trim($_POST['investorauto_sug_other']);
                $keywordsearch = $_POST['investorauto_sug_other'];
                $keywordhidden=ereg_replace(" ","_",$keyword);
                $month1=01; 
                $year1 = 2000;
                $month2= date('n');
                $year2 = date('Y');
            } else if(isset($_POST['investorauto_sug'])){
                
                $keyword=trim($_POST['investorauto_sug']);
                if($keyword != ""){
                    $month1=01; 
                    $year1 = 2000;
                    $month2= date('n');
                    $year2 = date('Y');
                }
            } else if(isset($_POST['investorauto'])){
                $investorauto=$_POST['investorauto'];
                $keywordsearch = $keyword=trim($_POST['keywordsearch']);
                $keywordhidden=trim($_POST['investorauto']);
            }else{
                $keywordsearch = $investorauto = $keyword=$keywordhidden='';
        }
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
                   $invester_filter_id .= ",";
        }
                  $invester_filter.=$myrow['name'];
                  $invester_filter_id .= $myrow['id'];
              $i++;
        
             }

            $investorsug_response= json_encode($response);

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
             $companyauto=$_POST['companyauto'];
            if(isset($_POST['companyauto_other']) && $_POST['companyauto_other'] !=''){
                $companyauto=$_POST['companyauto_other'];
                $companysearch=trim($_POST['companysearch_other']);
                $companysearchhidden=ereg_replace(" ","_",$companysearch);
          //  $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
                }
         if($companysearch!=''){
                $searchallfield='';
            }
            
                $companysearchhidden=ereg_replace(" ","_",$companysearch);
        }
        
        if($resetfield=="advisorsearch")
        { 
         $_POST['advisorsearch']="";
         $advisorsearch="";
        }
        else 
        {
         $advisorsearch=trim($_POST['advisorsearch']);
        }
        $advisorsearchhidden= trim($advisorsearch);
        $advisorsearch="";
        
     
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
        if( $vcflagValue==0)
        {
        $TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
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
        else if($compId==$companyIdGlobal){
            $hideIndustry = " and (industryid=24) ";
        }
        else
        {
           $hideIndustry="";     
        }
        
            $addDelind="";

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
        }else{
            
             if($compId==$companyIdGlobal){
            $hideIndustry = " and (industryid=24) ";
            }
            
            if($compId==$companyIdGlobal)
            {
              $addDelind = " and (pec.industry=24)";
            }
            
        }
        if($resetfield=="industry")
        { 
         // $_POST['industry']="";
         // $industry="";
            $pos = array_search($_POST['resetfieldid'], $_POST['industry']);
            //print_r($_POST['industry']);
            $industry = $_POST['industry'];
            unset($industry[$pos]);
            $_POST['industry'] = $industry; //print_r($industry);exit();

        }
        else 
        {
            $industry=$_POST['industry'];
            if($industry!='--' && count($industry) >0){
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
        }
        if($resetfield=="invhead")
        { 
         $_POST['invhead']="";
         $investor_head="";
        }
        else 
        {
         $investor_head=trim($_POST['invhead']);
        }
        
        if($resetfield=="exitstatus")
        { 
         $_POST['exitstatus']="";
         $exitstatusvalue="";
        }
        else 
        {
         $exitstatusvalue=trim($_POST['exitstatus']);
        }
      // echo "<br>___".$exitstatusvalue;
        if($resetfield=="investorSale")
        { 
         $_POST['invSale']="";
         $investorSale="";
        }
        else 
        {
         $investorSale=trim($_POST['invSale']);
        }
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
        }
        

        $whereind="";
        $whereinvType="";
        $whereinvestorSale="";
        $wheredates="";
        $wheredates1="";
        $whereexitstatus="";
        $whereReturnMultiple="";

        $notable=false;
        $searchallfield=$_POST['searchallfield'];
        $searchallfieldhidden=ereg_replace(" ","-",$searchallfield);
        if($searchallfield!=''){
            $_POST['tagsearch']="";
        }
        //  echo "<br>FLAG VALIE--" .$vcflagValue;
        if($vcflagValue==0)
        {
                $addVCFlagqry = "" ;
                $showallcompInvFlag=3;
                $searchTitle = "List of PE-backed IPOs ";
                $searchAggTitle = "Aggregate Data - PE-backed IPOs ";
        }
        elseif($vcflagValue==1)
        {
                $addVCFlagqry = " and VCFlag=1 ";
                $showallcompInvFlag=4;
                $searchTitle = "List of VC-backed IPOs ";
                $searchAggTitle = "Aggregate Data - VC-backed IPOs ";
        }
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
               
        $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
        $splityear1=(substr($year1,2));
        $splityear2=(substr($year2,2));

        if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
        {
            $sdatevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
            $edatevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
            $dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-01";
            $wheredates1= " and IPODate between '" . $dt1. "' and '" . $dt2 . "'";
        }
            $datevalueDisplay1= $sdatevalueDisplay1;
            $datevalueDisplay2= $edatevalueDisplay2;

       $aggsql= "select count(pe.IPOId) as totaldeals,sum(pe.IPOSize) as totalamount from ipos as pe,industry as i,pecompanies as pec where";

        if($range != "--")
        {
                $rangesql= "select startRange,EndRange from investmentrange where InvestRangeId=". $range ." ";
                if ($rangers = mysql_query($rangesql))
                {
                        While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
                        {
                                $startRangeValue=$myrow["startRange"];
                                $endRangeValue=$myrow["EndRange"];
                                $rangeText=$myrow["RangeText"];

                        }
                }
        }
        if($exitstatusvalue=="0")
          $exitstatusdisplay="Partial Exit";
        elseif($exitstatusvalue=="1")
          $exitstatusdisplay="Complete Exit";
        else
          $exitstatusdisplay="";
      //print_r($_POST);
      //  if ((trim($keyword)=="") && (trim($companysearch)=="")  && ($searchallfield=="") && ($industry =="--") && ($investorType == "--") && ($exitstatusvalue=="--") && ($investorSale == "--")&& ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--")  )
        $orderby=""; $ordertype="";   
        
        
         if(isset($_REQUEST['searchallfield_other'])){
                $searchallfield=$_REQUEST['searchallfield_other'];
               $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                                $month1=01; 
                                $year1 = 1998;
                                $month2= date('n');
                                $year2 = date('Y');                                
                              
        }
        
        // if($resetfield=="tagsearch")
        // { 
        //     $_POST['tagsearch']="";
        //     $tagsearch="";
        // }
        // elseif($_POST['tagsearch']  && $_POST['tagsearch'] !=''){
            
        //     $tagsearch="tag:".trim($_POST['tagsearch']);
        // }
        if($resetfield=="tagsearch"){
            $arrayval=explode(",",$_REQUEST['tagsearch_auto']);
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
            /*$_POST['tagsearch']="";
            $_POST['tagsearch_auto'] = "";
            $tagsearch = "";
            $tagandor=0;*/
           
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
               // echo "test2";
                $tagsearch = $_POST['tagsearch_auto'];
              //  print_r($tagsearch);
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
        }
        
        if($_SESSION['PE_industries']!=''){

            $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
        }
        
        
        if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
         {
            $companysql = "select DISTINCT pei.IPOId,pei.PECompanyID,pec.companyname,pec.industry,i.industry,
                pec.sector_business as sector_business ,pei.IPOSize,IPOAmount,IPOValuation,IPODate as dates,DATE_FORMAT(IPODate,'%b-%Y') as IPODate,
                pec.website,pec.city,pei.IPOId,pei.Comment,MoreInfor,hideamount,hidemoreinfor,
                (SELECT GROUP_CONCAT( inv.Investor separator ', ') FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pei.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv 
                where IPODate between '" . $getdt1. "' and '" . $getdt2 . "' AND i.industryid=pec.industry and
                pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
                pei.Deleted=0 " .$addVCFlagqry. " ".$addDelind.$comp_industry_id_where." GROUP BY pei.IPOId ";
                $orderby="IPODate";
                $ordertype="desc";
//                         echo "<br>all dashboard" .$companysql;
         }
        elseif(count($_POST)==0)    
        {

                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $iftest=1;
                        $yourquery=0;
                        $companysql = "select DISTINCT pei.IPOId,pei.PECompanyID as companyid,pec.companyname,pec.industry,i.industry,
                        pec.sector_business as sector_business,pei.IPOSize,IPOAmount,IPOValuation,IPODate as dates,DATE_FORMAT(IPODate,'%b-%Y') as IPODate,
                        pec.website,pec.city,pei.IPOId,pei.Comment,MoreInfor,hideamount,hidemoreinfor,
                        (SELECT GROUP_CONCAT( inv.Investor separator ', ') FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pei.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                        from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv  where";

                        if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                        {
                                $qryDateTitle ="Period - ";
                                $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                        }
                        if(($wheredates != "") )
                        {
                                $companysql = $companysql . $wheredates ." and ";
                                $aggsql = $aggsql . $wheredates ." and ";
                                $bool=true;
                        }
                        $companysql = $companysql . "  i.industryid=pec.industry and
                                pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
                                pei.Deleted=0 " .$addVCFlagqry. " ".$addDelind.$comp_industry_id_where." GROUP BY pei.IPOId ";
                        $orderby="IPODate";
                        $ordertype="desc";
                       // echo $companysql;

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


                    $companysql="SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                    pe.IPOSize,pe.IPOAmount, pe.IPOValuation,IPODate as dates,DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,
                    pec.website,pec.city, pec.region, pe.IPOId,
                    pe.Comment,MoreInfor,hideamount,hidemoreinfor,
                    (SELECT GROUP_CONCAT( inv.Investor separator ', ') FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                    FROM ipos AS pe, industry AS i,
                    pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                    WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                    " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $tagsval ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId $comp_industry_id_where GROUP BY pe.IPOId";
                    $orderby="IPODate";
                    $ordertype="desc";
                    //  echo "<br>Query for company search";
                    //  echo "<br> Company search--" .$companysql;
                }
                elseif ($searchallfield != "")
                {
                        $iftest=5;
                        $yourquery=1;
                        $datevalueDisplay1="";
                        $datevalueCheck1="";
                        
                        /*$tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%' OR sector_business LIKE '$searchallfield%' or  MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '$searchallfield%' or pec.tags like '%$searchallfield%'";*/
                        $searchExplode = explode( ' ', $searchallfield );
                        foreach( $searchExplode as $searchFieldExp ) {
                           /* $cityLike .= "pec.city LIKE '$searchallfield%' AND ";
                            $companyLike .= "pec.companyname LIKE '%$searchallfield%' AND ";
                            $sectorLike .= "sector_business LIKE '%$searchallfield%' AND ";
                            $moreInfoLike .= "MoreInfor LIKE '%$searchallfield%' AND ";
                            $investorLike .= "InvestmentDeals LIKE '%$searchallfield%' AND ";
                            $industryLike .= "i.industry LIKE '%$searchallfield%' AND ";
                            $websiteLike .= "pec.website LIKE '%$searchallfield%' AND ";*/
                            $cityLike .= "pec.city REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                            $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                            $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                            $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                            $investorLike .= "InvestmentDeals REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                            $industryLike .= "i.industry REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                            $websiteLike .= "pec.website REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                            $tagsLike .= "(pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,') and ";
                        }
                        $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                        $cityLike = '('.trim($cityLike,'AND ').')';
                        $companyLike = '('.trim($companyLike,'AND ').')';
                        $sectorLike = '('.trim($sectorLike,'AND ').')';
                        $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
                        $investorLike = '('.trim($investorLike,'AND ').')';
                        $industryLike = '('.trim($industryLike,'AND ').')';
                        $websiteLike = '('.trim($websiteLike,'AND ').')';
                        $tagsLike = '('.trim($tagsLike,'AND ').')';
                        $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;                                    
                        
                        $companysql="SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                        pe.IPOSize,pe.IPOAmount, pe.IPOValuation,IPODate as dates,DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,
                        pec.website,pec.city, pec.region, pe.IPOId,
                        pe.Comment,MoreInfor,hideamount,hidemoreinfor,
                        (SELECT GROUP_CONCAT( inv.Investor separator ', ') FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                        FROM ipos AS pe, industry AS i,
                        pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                        " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $tagsval ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId $comp_industry_id_where GROUP BY pe.IPOId";
                        $orderby="IPODate";
                        $ordertype="desc";
                //  echo "<br>Query for company search";
//           echo "<br> Company search--" .$companysql;
                }
                elseif ($companysearch != "")
                {
                         $iftest=3;
                        $yourquery=1;
                        $datevalueDisplay1="";
                        $datevalueCheck1="";
                        $companysql="SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                        pe.IPOSize,pe.IPOAmount, pe.IPOValuation,IPODate as dates,DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,
                        pec.website,pec.city, pec.region, pe.IPOId,
                        pe.Comment,MoreInfor,hideamount,hidemoreinfor,
                        (SELECT GROUP_CONCAT( inv.Investor separator ', ') FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                        FROM ipos AS pe, industry AS i,
                        pecompanies AS pec
                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                        " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.PECompanyId IN ($companysearch)) $comp_industry_id_where  GROUP BY pe.IPOId ";
                        $orderby="IPODate";
                        $ordertype="desc";
                //  echo "<br>Query for company search";
         //  echo "<br> Company search--" .$companysql;
                }
                elseif($keyword!="" && $keyword!=" ")
                {
                    if($_SESSION['PE_industries']!=''){

                        $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
                    }
                    
                    $iftest=4;
                    $yourquery=1;
                    $datevalueDisplay1="";
                    $datevalueCheck1="";
                    $companysql="select peinv.PECompanyId as companyid,c.companyname,c.industry,i.industry,sector_business as sector_business,peinv.IPOSize,IPOAmount,
                    peinv_invs.InvestorId,peinv_invs.IPOId,invs.Investor,IPODate as dates,
                    DATE_FORMAT( peinv.IPODate, '%b-%Y' )as IPODate,i.industry,hideamount,
                    (SELECT GROUP_CONCAT( inv.Investor separator ', ') FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =peinv.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                    from ipo_investors as peinv_invs,peinvestors as invs,
                    ipos as peinv,pecompanies as c,industry as i
                    where c.industry = i.industryid " .$wheredates1.
                    " and peinv.IPOId=peinv_invs.IPOId and c.PECompanyId=peinv.PECompanyId  and peinv.Deleted=0
                    " .$addVCFlagqry." ".$addDelind." and invs.InvestorId IN($keyword) and peinv_invs.IPOId =peinv.IPOId and invs.InvestorId=peinv_invs.InvestorId $comp_industry_id_where GROUP BY peinv.IPOId ";
                    $orderby="IPODate";
                    $ordertype="desc";
//              echo "<br> Investor search- ".$companysql;
                }
        

                elseif($advisorsearch!="" && $advisorsearch!=" ")
                {
                    if($_SESSION['PE_industries']!=''){

                        $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
                    }
                         $iftest=6;
                        $yourquery=1;
                        $datevalueDisplay1="";
                        $datevalueCheck1="";
                        $companysql="SELECT peinv.IPOId, peinv.PECompanyId as companyid, c.companyname, i.industry,
                        c.sector_business as sector_business,peinv.IPOSize,IPOAmount,IPODate as dates,DATE_FORMAT( peinv.IPODate, '%b-%Y' )as IPODate,
                        cia.CIAId, cia.cianame, adac.CIAId AS AcqCIAId,
                         hideamount,
                        (SELECT GROUP_CONCAT( inv.Investor separator ', ') FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =peinv.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                        FROM advisor_cias AS cia, ipos AS peinv, pecompanies AS c, industry AS i,
                        peinvestments_advisorcompanies AS adac
                        WHERE peinv.Deleted=0 and c.industry = i.industryid
                        AND c.PECompanyId = peinv.PECompanyId " .$addVCFlagqry." ".$addDelind." AND adac.CIAId=cia.CIAId and adac.PEId=peinv.IPOId and
                        cia.cianame LIKE '%$advisorsearch%'
                        AND c.industry !=15 $comp_industry_id_where GROUP BY peinv.IPOId ";
                        $orderby="companyname";
                        $ordertype="asc";
                        $fetchRecords=true;
                        $fetchAggregate==false;
//          echo "<br> Advisor Acquirer search- ".$companysql;
                }
                        elseif (($industry > 0) || ($exitstatusvalue!="--") ||  ($investorType != "--") || ($investorSale!="--" ) || (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--")) || (($txtfrm>=0) && ($txtto>0)) || ($yearafter != "") || ($yearbefore != "") || ($investor_head != "--") )
                { 
                                        
                                         $iftest=2;
                    $yourquery=1;

                    $dt1=$startyear;
                                        $dt2 =  $endyear;
                    $companysql = "select DISTINCT pei.IPOId,pei.PECompanyID as companyid,pec.companyname,pec.PECompanyId,pec.industry,i.industry,
                    pec.sector_business as sector_business,pei.IPOSize,IPOAmount,IPOValuation,IPODate as dates,DATE_FORMAT(IPODate,'%b-%Y') as IPODate,
                    pec.website,pec.city,pei.IPOId,pei.Comment,MoreInfor,hideamount,hidemoreinfor,
                                        (SELECT GROUP_CONCAT( inv.Investor separator ', ') FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pei.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                    from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv,peinvestors as inv where";
                    //echo "<br> individual where clauses have to be merged ";
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
                             if (($investorType!= "--")  && ($investorType!=""))
                        {
                            $qryInvType="Investor Type - " ;
                            $whereInvType = " pei.InvestorType = '".$investorType."'";
                        }
                        if ($investor_head != "--" && $investor_head != '') {
                               $whereInvhead = "inv.InvestorId=ipoinv.InvestorId and inv.countryid = '" . $investor_head . "'";
                        } 
                     if($exitstatusvalue!="--")
                                          {    $whereexitstatus=" pei.ExitStatus='".$exitstatusvalue."'";  }

                                          if($investorSale!="--")
                                          {    $whereinvestorSale=" pei.InvestorSale='".$investorSale."'";

                                          }
                                            if ($region!= "--")
                                            {
                                                    $qryRegionTitle="Region - ";
                                                    $whereregion = " pei.region ='".$region."'";
                                            }
                                            if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                            {
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                                            }

                                            if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn > '" .$txtfrm. "'"  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn < '" .$txtto . "'" ;
                                            }
                                            elseif(trim($txtfrm>0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn > '" .$txtfrm . "' and  ipoinv.MultipleReturn <'".$txtto. "'";
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
                                               // echo "<bR>***" .$whereReturnMultiple;
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
                    if($whereinvestorSale!="")
                                                {
                                                  $companysql=$companysql .$whereinvestorSale . " and ";
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
                                        if (($whereInvhead != "")) {
                                            $companysql = $companysql . $whereInvhead . " and ";
                                            $aggsql = $aggsql . $whereInvhead . " and ";
                                            $bool = true;
                                        }
                    $companysql = $companysql . "  i.industryid=pec.industry and
                    pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
                    pei.Deleted=0 " .$addVCFlagqry. " ".$addDelind.$comp_industry_id_where." GROUP BY pei.IPOId ";
                                        $orderby="IPODate";
                                        $ordertype="desc";
//                  echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                }
                                else
                {
                    echo "<br> INVALID DATES GIVEN ";
                    $fetchRecords=false;
                }
         $ajaxcompanysql=  urlencode($companysql);
       if($companysql!="" && $orderby!="" && $ordertype!="")
           $companysql = $companysql . " order by  dates desc,companyname asc "; 

    ?>

    <?php 
    $topNav = 'Deals';
    include_once('ipoheader_search.php');
    ?>
    <script type="text/javascript">
        // Start T960 ------------------------------------------------------->
        $(document).ready(function () {
        $('.exportcheck').iCheck('destroy');
        $('.allexportcheck').iCheck('destroy');
        $('.companyexportcheck').iCheck('destroy');
        $('.allexportcheck').iCheck('check');
                $(".allexportcheck").click(function() {
                    if ($(this).is(':checked')) {
                        $('.exportcolumn .exportcheck').attr('checked', true);
                        $('.exportcolumn .exportcheck').trigger('change');
                    } else {
                        $('.exportcolumn .exportcheck').attr('checked', false);
                        $(".resultarray").val('');
                    }
                });
                $(".companyexportcheck").click(function() {
                    if ($(this).is(':checked')) {
                        $('.exportcolumn .companyexportcheck').attr('checked', true);
                        $('.exportcolumn .companyexportcheck').trigger('change');
                    } else {
                        $('.exportcolumn .companyexportcheck').attr('checked', true);
                    }
                });

                $('.exportcheck').on('change',function () {
            
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
        // End T960 ----------------------------------------------------------->
        $("a.postlink").live('click',function(){

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
                $("#detailpost").attr("href","<?php echo BASE_URL;?>dealsnew/ipodealdetails.php?value="+idval).trigger("click");
            });
    </script>

    <style type="text/css">
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

 
    <td class="left-td-bg" >
        <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
 <?php include_once('iporefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
     <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>  
</div>
        </div>
</td>
    <?php
            $exportToExcel=0;;
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
                    $totalINRAmount=0.0;
                    $totalInv=0;
                    
                    $cos_array=array();
                    if($_SESSION['coscount']){ unset($_SESSION['coscount']); }
                     
                    $compDisplayOboldTag="";
                    $compDisplayEboldTag="";
                      //echo "<br> query final-----" .$companysql."/".$iftest;
                    /* Select queries return a resultset */
                    if ($companyrsall = mysql_query($companysql))
                    {
                        $company_cntall = mysql_num_rows($companyrsall);
                        While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                        {
                                $cos_array[]=$myrow["companyid"];
                        } 
                        
                    } 
                    $_SESSION['coscount'] =  $comp_count = count(array_count_values($cos_array));
                    //========================================junaid==========================================
                        foreach(array_count_values($cos_array) as $key=>$value){
                            $company_array[]=$key;
                        }
                        $comp_count = count(array_count_values($cos_array));
                        $company_array_comma = implode(",",$company_array); // junaid
                    //=========================================================================================
                    /*if( isset( $_POST[ 'pe_company' ] ) && !empty( $_POST[ 'pe_company' ] ) ) {
                        $cos_array = explode( ',', $_POST[ 'pe_company' ] );
                    }*/
                    if( $peEnableFlag ) {
                        if( empty( $pe_company ) ) {
                            $cos_array1  = '';
                            $comp_count = 0;
                        } elseif(!empty($_POST[ 'hide_pe_company'])){ // junaid
                                $cos_array1 = explode( ',', $_POST[ 'hide_pe_company'] );
                                $total_cos = count(array_count_values($cos_array1));
                            }else {
                            $cos_array1 = explode( ',', $pe_company );
                            $comp_count = count(array_count_values($cos_array1));
                        }
                    } else {
                        $cos_array1 = $cos_array;
                    }
                    if( isset( $_POST[ 'pe_checkbox' ] ) && !empty( $_POST[ 'pe_checkbox' ] ) ) {
                        $pecheckcount = count( $pe_checkbox );
                        $totalInv = @mysql_num_rows($companyrsall) - $pecheckcount;
                        $_SESSION['totalcount'] = $totalInv;
                    } else {
                        $totalInv = @mysql_num_rows($companyrsall);
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
                            $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('".$_SESSION['UserEmail']."','".$_SESSION['UserNames']."','".$searchallfield."',1,1,0,'".$search_date."','".$search_link."')";
                            mysql_query($search_query);
                        }
                        $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                        $notable=true;
                    }
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
                                 <li> 
                                  <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
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
                    </div>
                    <div class="result-rt-cnt">
                        <div class="result-count">
                        <?php if($VCFlagValue==0)
                            {

                                 if($studentOption==1)
                                 {
                                 ?>
                                     <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php echo $comp_count; ?></span> cos)</span>  
                                  <?php
                                 }
                                 else
                                 {  
                                 ?> 
                                     <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!='' && $searchallfield!=''){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span> 
                                 <?php  
                                 }
                                 ?>
                                 <!--  <span class="result-for" style="float:left;">  for PE-backed IPO</span> --> 
                                  <span class="result-for" style="float:left;"></span> 
                                  <span class="result-amount"><span>
                                  <span class="result-amount-no" id="show-total-amount"></span> 
                                  <span class="result-amount-no" id="show-total-inr-amount"></span>   
                                  <span class="is-inr">*</span>
                      <?php }
                         elseif($VCFlagValue==1) {
                       ?>
                        
                            <?php  
                            if($studentOption==1)
                            {
                            ?>
                             <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!='' && $searchallfield!=''){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span>  
                             <?php
                            }
                            else
                            {
                               /*if($exportToExcel==1)
                                 {*/
                                 ?> 
                                   <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!='' && $searchallfield!=''){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span> 
                                 <?php
                                 /*}
                                 else
                                 {
                                 ?>
                                         <span class="result-no">XXX Results Found</span> 
                                 <?php
                                 }*/
                            }
                            ?> 
                             <!--  <span class="result-for" style="float:left;">  for VC-backed IPO</span>   -->
                              <span class="result-for" style="float:left;"></span>  
                              <span class="result-amount"><span>
                              <span class="result-amount-no" id="show-total-amount"></span> 
                              <span class="result-amount-no" id="show-total-inr-amount"></span> 
                              <span class="is-inr">*</span>
                          
                 <?php }
                       ?>
                         <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                         <span>
                         <img class="callout" src="images/callout.gif">
                         <strong>Definitions
                         </strong>
                         </span></a>
                         <div class="title-links " id="export-btn"></div>
                         
                         </div>
                         <p class="inr-note"><b>* Based on current USD / INR Rate</b></p>
                     </div>
                         
               <?php 
                  }
                  else 
                   { ?>
                    <div class="lft-cn">
                      <ul class="result-select">
                            <?php
                            $cl_count = count($_POST);
                            if($cl_count ==2 || $cl_count >= 6)
                            {
                            ?>
                            <li class="result-select-close"><a href="<?php echo BASE_URL; ?>dealsnew/ipoindex.php?value=<?php echo $vcflagValue;?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                            <?php
                            }
                            if($industry >0 &&  $industry!=NULL ) { $drilldownflag=0;?>
                               <!-- <li> <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
                                <?php $industryarray = explode(",",$industryvalue); 
                                    $industryidarray = explode(",",$industryvalueid); 
                                    foreach ($industryarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('industry',<?php echo $industryidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>

                            <?php } if($investorType !="--" && $investorType !=""&& $investorType!=null){ $drilldownflag=0; ?>
                            <li> 
                                <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }  
                            if ($investor_head != "--" && $investor_head != null) {$drilldownflag = 0;?>
                              <li>
                                  <?php echo $invheadvalue; ?><a  onclick="resetinput('invhead');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                              </li>
                              <?php }
                            if($investorSale==1 && $investorSale!=NULL ){ $drilldownflag=0; ?>

                                <li>Investor Sale<a  onclick="resetinput('investorSale');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                            <?php } if($exitstatusdisplay!="" && $exitstatusdisplay!=NULL ) { $drilldownflag=0; ?>

                                <li><?php  echo $exitstatusdisplay; ?><a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                            <?php  }  if($datevalueDisplay1!=""){  
                            ?>
                           <li> 
                             <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
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
                            else if(trim($_POST['searchallfield'])!="" || trim($_POST['investorsearch'])!="" || trim($_POST['investorsearch'])!="" || trim($_POST['sectorsearch'])!=""  || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch'])!=""  )
                            {
                             ?>
                             <li style="padding:1px 10px 1px 10px;"> 
                                <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?>
                            </li>
                            <?php
                            }if(($txtfrm>=0) && ($txtto>0) && ($txtfrm!=NULL) && ($txtto!=NULL)  ) { $drilldownflag=0; ?>
                                  <li> <?php   echo $txtfrm. "-" .$txtto; ?><a  onclick="resetinput('returnmultiple');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                            <?php } if($keyword!=" " && $keyword!=NULL) { $drilldownflag=0; ?>
                                  <!-- <li> <?php  echo $invester_filter; ?><a  onclick="resetinput('investorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li> -->

                                  <?php 
                                    $investerarray = explode(",",$invester_filter); 
                                    $investeridarray = explode(",",$invester_filter_id); 
                                    foreach ($investerarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('investorsearch',<?php echo $investeridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>

                            <?php } if($advisorsearch!="" && $advisorsearch!=NULL) { $drilldownflag=0; ?>
                                  <li> <?php echo $advisorsearch; ?><a  onclick="resetinput('advisorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a> </li>
                            <?php } if($companysearch!=" " && $companysearch!=NULL){ $drilldownflag=0; ?>
                                  <li>  <?php echo $companyauto; ?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>

                            <?php }if($searchallfield!="" && $searchallfield!=NULL) { $drilldownflag=0; ?>
                                <li> <?php echo $searchallfield; ?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                            <?php } 
                             if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } 
                            if($tagsearch!=''){ ?>
                                     <?php $tagarray = explode(",",$tagsearch); 
             foreach ($tagarray as $key=>$value){  ?>
                  <li>
                      <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?> 
                               <!--  <li><?php echo "tag:".trim($tagsearch)?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
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
                        <div class="result-count">
                    <?php        
                        if($VCFlagValue==0)
                        {
                       ?>
                        
                           <?php  
                         if($studentOption==1)
                         {
                         ?>
                          <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php echo $comp_count; ?></span> cos)</span>  
                          <?php
                         }
                         else
                         {
                              ?> 
                                <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php echo $comp_count; ?></span> cos)</span> 
                              <?php
                              
                         }
                         ?>  
                          <span class="result-for" style="float:left;">  for PE-backed IPO</span>  
                          <span class="result-amount"><span>
                          <span class="result-amount-no" id="show-total-amount"></span> 
                           <span class="result-amount-no" id="show-total-inr-amount"></span>
                           <span class="is-inr">*</span> 
                       <?php }
                       elseif($VCFlagValue==1) {
                           
                         if($studentOption==1)
                         {
                         ?>
                          <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php echo $comp_count; ?></span> cos)</span>  
                          <?php
                         }
                         else
                         {
                              ?> 
                                <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php echo $comp_count; ?></span> cos)</span> 
                              <?php
                         }
                         ?> 
                              <span class="result-for" style="float:left;">  for VC-backed IPO</span>  
                              <span class="result-amount"></span>
                              <span class="result-amount-no" id="show-total-amount"></span> 
                              <span class="result-amount-no" id="show-total-inr-amount"></span>
                              <span class="is-inr">*</span> 
                        
                       <?php }
               ?>
                           
                  <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                  <span>
                  <img class="callout" src="images/callout.gif">
                  <strong>Definitions
                  </strong>
                  </span></a>
                  <div class="title-links " id="export-btn"></div>          
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

                  <!-- <div class="list-tab">
                       
                       <ul>
                        <li class="active"><a class="postlink"   href="ipoindex.php?value=<?php echo $VCFlagValue; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
                        <?php
                            
                            ?>
                        <li><a id="icon-detailed-view" class="postlink" href="ipodealdetails.php?value=<?php echo $comid;?>/<?php echo $VCFlagValue;?>/<?php echo $searchallfield;?>" ><i></i> Detail  View</a></li> 
                        </ul></div>-->
                    <?php
                         $count=0;
                             While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                            {
                                    if($count == 0)
                                    {
                                             $comid = $myrow["IPOId"];
                                            $count++;
                                    }
                            }
                        if ($company_cntall>0)
                          {
                             mysql_data_seek($companyrsall,0);
                             //Code to add PREV /NEXT
                             $icount = 0;
                             if ($_SESSION['resultId']) 
                                unset($_SESSION['resultId']); 
                              if ($_SESSION['resultCompanyId']) 
                                unset($_SESSION['resultCompanyId']); 
                             While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                             {
                                $industryAdded = $myrow[2];
                                //$totalInv=$totalInv+1;
                                $totalAmount=$totalAmount+$myrow["IPOSize"];
                                $totalINRAmount=$totalINRAmount+$myrow["IPOSize"];
                                //Session Variable for storing Id. To be used in Previous / Next Buttons
                                $_SESSION['resultId'][$icount] = $myrow["IPOId"];
                                $_SESSION['resultCompanyId'][$icount] = $myrow["PECompanyId"];
                                $icount++;
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

                         } ?>
        <a id="detailpost" class="postlink"></a> 
        <div class="view-table view-table-list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
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
                <th class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Company</th>
                <th class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                <th class="header <?php echo ($orderby=="investor")?$ordertype:""; ?>" id="investor">Investor</th>
                <th class="header <?php echo ($orderby=="dates")?$ordertype:""; ?>" id="dates" style="width: 180px;" >Date</th>
                <th   style="width: 120px;" class="alignr header asc <?php echo ($orderby=="IPOSize")?$ordertype:""; ?>" id="IPOSize">IPO Size (US$M)</th>
                </tr></thead>
              
              <tbody id="movies">
                     <?php
                        if ($company_cnt>0)
                          {
                             mysql_data_seek($companyrs,0);
                                unset($_SESSION['resultCompanyId']); 
                             While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                             {
                                $hideFlagset = 0;
                                    
                                    $prd=$myrow["IPODate"];
                                    if($myrow["hideamount"]==1)
                                    {
                                            $hideamount="--";
                                    }
                                    else
                                    {
                                            $hideamount=$myrow["IPOSize"];
                                    }
                                    if(trim($myrow["sector_business"])=="")
                                            $showindsec=$myrow["industry"];
                                    else
                                            $showindsec=$myrow["sector_business"];
                           ?>  
                           <?php 
                                if( $searchallfield != '' ) {
                                   /* if( !empty( $pe_checkbox ) ) {
                                        if( in_array( $myrow["IPOId"], $pe_checkbox ) ) {
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

                                                                if( (in_array( $myrow["IPOId"], $pe_checkbox )) ) {
                                                                        $checked = '';
                                                                        $rowClass = 'event_stop';

                                                                } 
                                                                elseif( (in_array( $myrow["IPOId"], $pe_checkbox_enable )) ) {
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

                                                                if( (in_array( $myrow["IPOId"], $pe_checkbox )) ) {
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

                                                                if( (in_array( $myrow["IPOId"], $pe_checkbox_enable )) ) {
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
                          <tr class="details_link <?php echo $rowClass; ?>" valueId="<?php echo $myrow["IPOId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>">
                            <?php 
                                if( $searchallfield != '' ) {
                            ?>
                            <td><input type="checkbox" data-deal-amount="<?php echo $myrow['IPOSize']; ?>" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow[ 'companyid' ]; ?>" class="pe_checkbox" <?php echo $checked; ?> value="<?php echo $myrow["IPOId"];?>" /></td>
                            <?php
                                }
                            ?>
                                <td ><a class="postlink" href="ipodealdetails.php?value=<?php echo $myrow["IPOId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
                               
                                <td><a class="postlink" href="ipodealdetails.php?value=<?php echo $myrow["IPOId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><?php echo trim($showindsec); ?></a></td>
                                <td><a class="postlink" href="ipodealdetails.php?value=<?php echo $myrow["IPOId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><?php  echo $myrow["Investor"]; ?></a></td>
                                <td><a class="postlink" href="ipodealdetails.php?value=<?php echo $myrow["IPOId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><?php echo $prd; ?></a></td>
                                <td style="text-align: right;"><a class="postlink" href="ipodealdetails.php?value=<?php echo $myrow["IPOId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><?php echo $hideamount; ?>&nbsp;</a></td>
                          </tr>
                        <?php
                            }
                         }
                        if( isset( $_POST[ 'pe_checkbox' ] ) && !empty( $_POST[ 'pe_checkbox' ] ) ) {
                            $pecheckcount = count( $pe_checkbox );
                            $totalInv = $totalInv - $pecheckcount;
                            $_SESSION['totalcount'] = $totalInv;
                        }
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
           <div class="pageinationManual">
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

                    <div class="pagination-section"><input type="text" name = "paginaitoninput" id = "paginationinput" class = "paginationtextbox" placeholder = "Page No" onkeyup = "paginationfun(this.value)">
                    <button class = "jp-page1 button pagevalue" name="pagination" id="pagination" type="submit" onclick = "validpagination()">Go</button></div>

                    </div>
  <?php 
        }
                 if($hidecount==1)
                    {
                            $totalAmount="--";
                            $totalINRAmount="--";
                    }
                if($studentOption==1)
        {
        ?>
        <div id="headingtextproboldbcolor">
                 <script type="text/javascript" >
                    $(document).ready(function(){
                    $("#show-total-amount").html('<h2> IPO Size (US$ M) <span><?php
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
                 <br /></div>
                <?php   if($exportToExcel==1)
                        {
                        ?>
                              <script type="text/javascript" >
                                    <?php if($vcflagValue == '0') { ?>
                                        $("#export-btn").html(' <aclass="export_new"  id="expshowdeals" data-type="multicheckbox" name="showdeals">Export</a>');
                                    <?php }else { ?>
                                        $("#export-btn").html(' <aclass="export_new"  id="expshowdeals" data-type="nomulticheckbox" name="showdeals">Export</a>');
                                    <?php }?>
                                </script>
                                <span style="float:right;margin-right:20px;" class="one">
                                <a class="export_new" id="expshowdealsbtn" name="showdeals">Export</a>
                                </span>
                                <div style="clear: both;"></div>
                  <?php } 
                }
        else
        {
                        /*if($exportToExcel==1)
                        {*/
                        ?>  
                            <script type="text/javascript" >
                                $(document).ready(function(){
                                $("#show-total-amount").html('<h2> IPO Size (US$ M) <span><?php 
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
                        
        
                        if(($totalInv>0) &&  ($exportToExcel==1))
                        {

                     ?>
                        <script type="text/javascript" >
                            <?php if($vcflagValue == '0') { ?>
                                $("#export-btn").html('<a class="export_new" id="expshowdeals" data-type="multicheckbox" name="showipodeals">Export</a>');
                            <?php }else { ?>
                                $("#export-btn").html('<a class="export_new" id="expshowdeals" data-type="nomulticheckbox" name="showipodeals">Export</a>');
                            <?php } ?>
                            </script>
                            <span style="float:right;margin-right:20px;" class="one">
                                    <a class="export_new" id="expshowdealsbtn" name="showipodeals">Export</a>
                            </span>
                            <div style="clear: both;"></div>
            <?php
                        }

            elseif(($totalInv>0) && ($exportToExcel==0))
            {
                        ?>
                             <div>
                                    <span>
                                    <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing PE-backed IPOs.  </p>
                                    <span style="float:right;margin-right:20px;" class="one">
                                         <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                                    <a class ="export" target="_blank" href="../xls/sample-pe-backed-IPOs.xls">Sample Export</a>
                                    </span>
                                    <div style="clear: both;"></div>
                                    <script type="text/javascript">
                        $('#export-btn').html('<a class="export"  href="../xls/sample-pe-backed-IPOs.xls">Export Sample</a>');
                                    </script>
                                    </span>
                            </div>
                        <?php
                        }
        } //end of student if
        ?>
    
    
                <?php } elseif($buttonClicked=='Aggregate')
                        {

                                $aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                                and  pe.Deleted=0 " .$addVCFlagqry.
                                                         " order by pe.IPOSize desc,IPODate desc";
                                        //echo "<br>Agg SQL--" .$aggsql;
                                         if ($rsAgg = mysql_query($aggsql))
                                         {
                                                $agg_cnt = mysql_num_rows($rsAgg);
                                         }
                                           if($agg_cnt > 0)
                                           {
                                                         While($myrow=mysql_fetch_array($rsAgg, MYSQL_BOTH))
                                                           {
                                                                        $totDeals = $myrow["totaldeals"];
                                                                        $totDealsAmount = $myrow["totalamount"];
                                                                }
                                           }
                                           else
                                           {
                                                        $searchTitle= $searchTitle ." -- No Investments found for this search";
                                           }
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
                                                if($dealtype!= "--")
                                                {
                                                        $dealSql= "select Stage from dealtypes where StageId=$stage";
                                                        if($rsDealType=mysql_query($dealSql))
                                                        {
                                                          while($mydealRow=mysql_fetch_array($rsDealType,MYSQL_BOTH))
                                                          {
                                                                $stageqryValue=$mydealRow["Stage"];
                                                          }
                                                        }
                                                 }
                                                if($range!= "--")
                                                {
                                                        $rangeqryValue= $range;
                                                }
                                                if($wheredates !== "")
                                                {
                                                        $dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
                                                }
                                                $searchsubTitle="";
                                                if(($industry==0) && ($wheredates==""))
                                                {
                                                        $searchsubTitle= "All";
                                                }

                        ?>
                                <div id="headingtextpro">
                                <div id="headingtextproboldfontcolor"> <?php echo $searchAggTitle; ?> <br />  <br /> </div>
                                <div id="headingtextprobold"> Search By :  <?php echo $searchsubTitle; ?> <br /> <br /></div>
                        <?php
                                $spacing="<Br />";
                                if ($industry > 0)
                                {

                        ?>
                                        <?php echo $qryIndTitle; ?><?php echo $indqryValue; ?> <?php echo $spacing; ?>
                        <?php
                                }

                                if($wheredates!="--")
                                {
                        ?>
                                        <?php echo $qryDateTitle; ?><?php echo $dateqryValue; ?> <?php echo $spacing; ?>
                        <?php
                                }
                        ?>
                                <div id="headingtextprobold"> <br />No of Deals : <?php echo $totDeals; ?>  <br /> <br/></div>
                                <div id="headingtextprobold"> Value (US $M) : <?php echo $totDealsAmount; ?>   <br /></div>
                                </div>
                        <?php
                        } 
                ?>
    </div>
        
        <?php /*if( $company_cnt > 0 ) {*/ ?> 
         <div class="other_db_search">            
        <div class="other_db_searchresult">
            <p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>
        </div>     
        </div>
        <?php /*}*/ ?>
    <div class="overview-cnt mt-trend-tab">
    <div class="showhide-link"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? '' : ''; ?>" rel="#slidingTable" id='ldtrend'><i></i><span>Trend View</span></a></div>

  <div  id="slidingTable" style="display: none;overflow:hidden;">  
   <?php
    include_once("ipotrendview.php");
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
                 <?php if ($vcflagValue == 0 || $hide_pms==1) { ?>
                <input style="float:right;margin-top:9px;margin-right:5px;" class ="export" type="button" id="exporttrend"  value="Export" name="exporttrend">
             <?php } ?>
                <a href="#" class="show_hide" rel="#slidingDataTable">View Table</a>
             </div>

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
    <form name="pelisting" id="pelisting" method="post" action="exportipodeals.php">  
        
        <?php if($_POST) { ?>
        
        <input type="hidden" name="txtsearchon" value="2" >
        <!-- T960 -------------------------------------------------------------------->
        <input type="hidden" class="resultarray" name="resultarray" value=""/>
        <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
        <input type="hidden" name="txthidename" value=<?php echo $UserNames; ?> >
        <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
        <input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
        <input type="hidden" name="txthideindustryid" value=<?php echo $industry_hide; ?> >
        <input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
        <input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
        <input type="hidden" name="txthideexitstatusvalue" value=<?php echo $exitstatusvalue; ?> >
        <input type="hidden" name="txthideinvestorSale" value=<?php echo $investorSale; ?> >
        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
        <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
        <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
        <input type="hidden" name="txthideReturnMultipleFrm" value=<?php echo $txtfrm; ?> >
        <input type="hidden" name="txthideReturnMultipleTo" value=<?php echo $txtto; ?> >
        <input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
        <input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
        <input type="hidden" name="txthideadvisor" value=<?php echo $advisorsearchhidden; ?> >
        <input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
        <input type="hidden" name="yearafter" value=<?php echo $yearafter; ?> >
        <input type="hidden" name="yearbefore" value=<?php echo $yearbefore; ?> >
        <input type="hidden" name="invhead" value=<?php echo $investor_head; ?> >
        <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode( ',', $pe_checkbox ); ?>">
    <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
    <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
    <input type="hidden" name="tagsearch" value="<?php echo $tagsearch; ?>" >
        <input type="hidden" name="tagandor" value="<?php echo $tagandor; ?>" >
        
        <?php } else { ?>
        <!-- T960 ------------------------------------------------------------>
        <input type="hidden" class="resultarray" name="resultarray" value=""/>
        <input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
        <input type="hidden" name="txthidename" value=<?php echo $UserNames; ?> >
        <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
        <input type="hidden" name="txthideindustry" value="">
        <input type="hidden" name="txthideindustryid" value="--">
        <input type="hidden" name="txthideinvtype" value="">
        <input type="hidden" name="txthideinvtypeid" value="--">
        <input type="hidden" name="txthideexitstatusvalue" value="--">
        <input type="hidden" name="txthideinvestorSale" value="--">
        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
        <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
        <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
        <input type="hidden" name="txthideReturnMultipleFrm" value="">
        <input type="hidden" name="txthideReturnMultipleTo" value="">
        <input type="hidden" name="txthideinvestor" value="">
        <input type="hidden" name="txthidecompany" value="">
        <input type="hidden" name="txthideadvisor" value="">
        <input type="hidden" name="txthidesearchallfield" value="">
        <input type="hidden" name="yearafter" value="">
    <input type="hidden" name="yearbefore" value="" >
    <input type="hidden" name="invhead" value="" >
        <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode( ',', $pe_checkbox ); ?>">
    <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
    <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
        <input type="hidden" name="tagsearch" value="<?php echo $tagsearch; ?>" >
        <input type="hidden" name="tagandor" value="<?php echo $tagandor; ?>" >
        <?php }?>
    </form>
    <?php if($type==4){ ?>
       
        <form name="exporttrend" id="exporttable"  method="post" action="ajxipoExcel.php">
            <input type="hidden" id="exporttablesql" name="exporttablesql" value="<?php echo $compRangeSql; ?>" >
            <!--input type="hidden" id="vcflagValue" name="vcflagValue" value="<?php echo $vcflagValue; ?>" -->
            <input type="hidden" id="type" name="type" value="<?php echo $type; ?>" >
            <input type="hidden" id="range" name="range" value="<?php echo implode('#',$range);?>" >
        </form>
        
        <?php  }else{ ?>
        
        <form name="exporttrend" id="exporttable"  method="post" action="ajxipoExcel.php">
            <input type="hidden" id="exporttablesql" name="exporttablesql" value="<?php echo $companysql; ?>" >
            <!--input type="hidden" id="vcflagValue" name="vcflagValue" value="<?php echo $vcflagValue; ?>" -->
            <input type="hidden" id="type" name="type" value="<?php echo $type; ?>" >
        </form>
    <?php  } ?>
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
           $(document).ready(function(){ 


     });              
        function  loadhtml(pageno,orderby,ordertype)
        {
            var peuncheckVal = $( '#pe_checkbox_disbale' ).val();
            var full_check_flag =  $( '#all_checkbox_search' ).val();//junaid
            var pecheckedVal = $( '#pe_checkbox_enable' ).val();//junaid
           jQuery('#preloading').fadeIn(1000);   
           $.ajax({
           type : 'POST',
           url  : 'ajaxListview_ipo.php',
           data: {

                   sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                   totalrecords : '<?php echo addslashes($company_cntall); ?>',
                   page: pageno,
                   vcflagvalue:'<?php echo $vcflagValue; ?>',
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
                    updateCountandAmount( peuncheckINRAmount, peuncheckAmount, 'add', amountChnage, pehideFlag, total_invdeal  );
                    updateCompanyCount( peuncheckCompany, 'add', lastElement, pehideFlag ,total_invcompany);
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
                    
                    updateCountandAmount( peuncheckINRAmount, peuncheckAmount, 'remove', amountChnage, pehideFlag, total_invdeal  );
                    updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag,total_invcompany );
                }
                
            });
            
             //------------------------------junaid--------------------------------
                   
             $( '.all_checkbox' ).on( 'ifChanged', function(event) {
                
                 if( $( event.target ).prop('checked') ) {
               
                    $( '#pe_checkbox_company' ).val($("#array_comma_company").val());
                   
                    $( '.result-count .result-no span.res_total').text( $("#real_total_inv_deal").val() );
                    $( '#show-total-amount h2 span' ).text($("#real_total_inv_amount").val() );
                    $( '#show-total-inr-amount h2 span' ).text($("#real_total_inv_inr_amount").val() );
                    $( '.result-count .result-no span.comp_total').text($("#real_total_inv_company").val());
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
                     $( '.result-count .result-no span.comp_total').text('0');
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

          function updateCountandAmount( elementINRAmount, elementAmount, type, amountFlag, pehideFlag , total_invdeal) {
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
            function updateCompanyCount( elementCompany, type, lastElement, pehideFlag ) {
                var counts = {};
                var removedcompanyData = '';
                var companyData = $( '#pe_checkbox_company' ).val();
                if( type == 'remove' ) {
                    if( pehideFlag == 0 ) {
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
                $( '#total_inv_company').val(Object.keys(counts).length); //junaid
            }

       </script>
       <script type="text/javascript">

    /*$('#expshowdeals').live('click',function(){ 
            $("#pelisting").submit();
            return false;
     });
    
    $(".export").click(function(){
        $("#pelisting").submit();
    });*/
    
    
    
    // $('#expshowdeals').click(function(){ 
        
    //     jQuery('#maskscreen').fadeIn();
    //     jQuery('#popup-box-copyrights').fadeIn();   
    //     return false;
    // });
    // T960 ------------------------------------------------------->
    $('#expshowdeals').click(function(){ 
        $exportmultiselect = $('#expshowdeals').attr("data-type");
        if($exportmultiselect == 'multicheckbox'){
            jQuery('#maskscreen').fadeIn();
            jQuery('#popup-box-copyrights').fadeIn();  
            $('.exportcheck').iCheck('destroy');
            $('.allexportcheck').iCheck('destroy');
            $('.companyexportcheck').iCheck('destroy');
            $('.allexportcheck').iCheck('check');
            $(".resultarray").val('Select-All');
            $('.exportcolumn .exportcheck').attr('checked', true);
            return false;
        }else if($exportmultiselect == 'nomulticheckbox'){
            jQuery('#maskscreen').fadeIn();
            jQuery('#popup-box-copyrights-filter').fadeIn();  
            $(".resultarray").val('Select-All');
            return false;
        }
    });
    // End T960 ---------------------------------------------------->

    $('#expshowdealsbtn').click(function(){ 
        
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });
      // Start T960 --------------------------------------------->
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
                 if(result.length > 0) {
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
    // End T960 ------------------------------------------------------->
      
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
                        hrefval= 'exportipodeals.php';
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

    
    
    
    
    /*$("a.postlink").live('click',function(){

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
                $("#detailpost").attr("href","<?php echo GLOBAL_BASE_URL; ?>dealsnew/ipodealdetails.php?value="+idval).trigger("click");
            });*/
   </script>
   <script type="text/javascript">
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
       </script>
        
        <form id="other_db_submit" method="post">
                <input type="hidden" name="searchallfield_other" id="other_searchallfield" value="<?php echo$searchallfield;?>">
                <input type="hidden" name="companyauto_other" id="companyauto_other" value="<?php echo $companyauto;?>">
                <input type="hidden" name="companysearch_other" id="companysearch_other" value="<?php echo $companysearch;?>">
                <input type="hidden" name="investorauto_sug_other" id="investorauto_sug_other" value="<?php echo $investorauto;?>">
                <input type="hidden" name="keywordsearch_other" id="keywordsearch_other" value="<?php echo $keywordsearch;?>">
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
</div>  -->
  <!-- T960 -->
  <div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 100% !important; display: none;"></div>
<!-- <div class="lb" id="popup-box-copyrights" style="width:650px !important;"> -->
<div class="lb" id="popup-box-copyrights" style="width:65% !important;left:20%;top:10%;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <!-- <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
   -->
   <div class="copyright-body">
    <h3  style="text-align: center;font-size:19px;">Select fields for excel file export</h3>
    <div class="row">
        <label style="font-weight: 600;"><input type="checkbox" class="allexportcheck"/> Select All</label>
        <ul class="exportcolumn">
        <!-- <li><input type="checkbox" class="companyexportcheck" name="skills" value="PortfolioCompany" checked/> <span> Portfolio Company</span></li> -->
        <li><input type="checkbox" class="exportcheck" name="skills" value="PortfolioCompany"/> <span> Portfolio Company</span></li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="CIN"/> <span>CIN</span></li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="YearFounded" /> Year Founded</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="PEFirm" /> PE Firm(s)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="InvestorType" /> Investor Type</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="ExitStatus" /> Exit Status</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="InvestorSale" /> Investor Sale ?</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="Industry" /> Industry</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="SectorBusinessDescription" /> Sector_Business Description</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="Website" /> Website</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="Date" /> Date </li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="IPOSize" /> IPO Size (US$M)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="Price" /> Price (Rs.)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="IPOValuation" /> IPO Valuation (US$M)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="SellingInvestors" /> Selling Investors</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="AddlnInfo" /> Addln Info (Overall IPO)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="InvestmentDetails" /> Investment Details</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="ReturnMultiple" /> Return Multiple</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="IRR" /> IRR (%)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="MoreInfoReturns" /> More Info(Returns)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="CompanyValuation" /> Company Valuation (INR Cr)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="RevenueMultiple" /> Revenue Multiple</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDAMultiple" /> EBITDA Multiple</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="PATMultiple" /> PAT Multiple</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="PricetoBook" /> Price to Book</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="ValuationMoreInfo" /> Valuation (More Info)</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue" /> Revenue</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA" /> EBITDA</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="PAT" /> PAT</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="BookValuePerShare" /> Book Value Per Share</li>
        <li><input type="checkbox" class="exportcheck" name="skills" value="PricePerShare" /> Price Per Share</li>
        <!-- <li><input type="checkbox" class="exportcheck" name="skills" value="LinkforFinancials" /> Link for Financials</li> -->

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
    <div class="cr_entry" style="text-align:center;margin-top:25px;">
        <input type="button" value="Submit" id="agreebtn" />
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

    ?>
<?php 
//ech
if($type==1 && $vcflagValue==0)
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
              window.location.href = 'ipoindex.php?'+query_string;
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
                  });
             
             //Fill table
             var pintblcnt = '';
             var tblCont = '';
                         
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
             //pintblcnt = pintblcnt + '</thead>';
             //pintblcnt = pintblcnt + '<tbody>';
             
             //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
             //tblCont = tblCont ;
                        //tblCont = tblCont;
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
            // tblCont = tblCont + '</tbody>';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
             
             //updateTables();
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
    }
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
             <?php if($drilldownflag==1){ ?>              window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
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
                  });
              
            //Fill table
             var pintblcnt = '';
             var tblCont = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
             
             //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
            // tblCont = tblCont + '</thead>';
            // tblCont = tblCont + '<tbody>';
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
            // tblCont = tblCont + '<tbody>';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
      }
     
    </script>
      <?php
        
    }
else if($type==1 && $vcflagValue==3) //Not used
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
             <?php if($drilldownflag==1){ ?>              window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
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
             
            // tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
            // tblCont = tblCont + '</thead>';
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
             //tblCont = tblCont + '<tbody>';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
else if($type==2 && $vcflagValue==0) 
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
                     window.location.href = 'ipoindex.php?'+query_string;
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
                 window.location.href = 'ipoindex.php?'+query_string;
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
                    /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
               colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
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
    
       
    <?php 
     }
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
                     window.location.href = 'ipoindex.php?'+query_string;
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
                /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                 window.location.href = 'ipoindex.php?'+query_string;
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
                    /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
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
            // tblCont = tblCont + '</tbody>';

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
else if($type==2 && $vcflagValue==3) //not used
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
                     window.location.href = 'ipoindex.php?'+query_string;
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
              /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                 window.location.href = 'ipoindex.php?'+query_string;
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
                    /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
             
            // tblCont = '<thead>';
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
              
             
            // tblCont = tblCont + '</thead>';
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
            // tblCont = tblCont + '</tbody>';

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
             window.location.href = 'ipoindex.php?'+query_string;
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
                /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
                 window.location.href = 'ipoindex.php?'+query_string;
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
                   /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              draw(data3, {title:"No of Deal"/*,
      colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
             // Create and draw the visualization.
            var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
            chart.draw(data4, {title:"Amount"/*,colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
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
             
             //tblCont = '<thead>';
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
             //tblCont = tblCont + '</tbody>';

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
             window.location.href = 'ipoindex.php?'+query_string;
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
                /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
                 window.location.href = 'ipoindex.php?'+query_string;
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
                  /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              draw(data3, {title:"No of Deal"/*,
      colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
             // Create and draw the visualization.
            var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
            chart.draw(data4, {title:"Amount"/*,colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
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
             
             //tblCont = '<thead>';
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
             window.location.href = 'ipoindex.php?'+query_string;
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
                /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
                 window.location.href = 'ipoindex.php?'+query_string;
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
              draw(data3, {title:"No of Deal"/*,
      colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            console.log(dealdata);
            
            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);          
            }
             // Create and draw the visualization.
            var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
            chart.draw(data4, {title:"Amount"/*,colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
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
             
            // tblCont = '<thead>';
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
     }
else if($type==4 && $vcflagValue==0)
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart7, 'select', selectHandler2);
              chart7.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                  colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                  colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
             
            // tblCont = '<thead>';
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
                
                //console.log(dataArray[arrhead[i]]);
            }
            
             
            // tblCont = tblCont + '</tbody>';
             pintblcnt = pintblcnt + '</table>';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
    
        }
    </script>
       
    <?php 
     }
else if($type==4 && $vcflagValue==1) 
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart7, 'select', selectHandler2);
              chart7.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                  colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                 /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
             
            // tblCont = '<thead>';
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
                
                //console.log(dataArray[arrhead[i]]);
            }
            
             
            // tblCont = tblCont + '</tbody>';
             pintblcnt = pintblcnt + '</table>';
             
             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
            
              
        }
    </script>
       
    <?php 
     }
else if($type==4 && $vcflagValue==3) // Not used
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                 <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
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
                  colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
                  colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
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
                
                //console.log(dataArray[arrhead[i]]);
            }
            
             
            // tblCont = tblCont + '</tbody>';
             pintblcnt = pintblcnt + '</table>';
             
             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
            
              
        }
    </script>
       
    <?php 
     }
else if($type==5 && $vcflagValue==0)  
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
         colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
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
            // tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);   
             $('.pinned').html(pintblcnt);
            
          
        }
        
        </script>
       
    <?php 
     }
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
          colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
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
     }
else if($type==5 && $vcflagValue==3) // Not used
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               c/*olors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
           /*     colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
          colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
             var tblCont = '';
             var pintblcnt = '';
             
             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';
             
             //tblCont = '<thead>';
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
              /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              draw(data3, {title:"No of Deals"/*,colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
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
            // tblCont = tblCont + '</tbody>';

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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
              /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              draw(data3, {title:"No of Deals"/*,colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
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
            // tblCont = tblCont + '</tbody>';

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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              draw(data3, {title:"No of Deals"/*,colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
              colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
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
            
            console.log(dataArray);
            
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
            // tblCont = tblCont + '</tbody>';

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
             window.location.href = 'index.php?'+query_string;
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
                /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /*colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
     /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
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
     colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
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
             <?php if($drilldownflag==1){ ?>             window.location.href = 'ipoindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
      colors: ["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
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
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <?php 
    }
    mysql_close();
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
<?php  /*if($_POST || $vcflagValue==0 || $vcflagValue==1)
        { ?>
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
        <?php } */?>
                                        
</script> 
    
  <style>
  /*T960 start ----------------------------------------------------*/
  ul.exportcolumn {
                -webkit-column-count: 4;
                -moz-column-count: 4;
                column-count: 4;
            }
        .exportcolumn li,.copyright-body label{
            line-height:35px;
        }
    /*T960 end ----------------------------------------------------*/
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
            font-size: 14px;
                                
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
    </style>
    <script>
    <?php 
    
      if($vcflagValue == '0')
                {
                    $section="PE-Exits-IPO";
                }
                else if($vcflagValue == '1')
                {
                     $section="VC-Exits-IPO";
                }
                
    
    if($searchallfield!=''){ ?>
        $(document).ready(function(){
            
            <?php if ($company_cnt==0){ ?>
                              $('.other_db_search').css('margin-top','50px');
            <?php } ?>
                
            $('.other_db_search').fadeIn();            
           $.get( "gmail_like_search.php?section=<?php echo $section;?>&search=<?php echo$searchallfield;?>", function( data ) {          
           
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
     // Tag Search
    var tagsearchval = $('#tagsearch').val();
    if(tagsearchval == ''){
        $('.acc_trigger.helptag').removeClass('active').next().hide();
    }
    // Tag search
 <?php if(  ($company_cnt==0) &&    ( trim($invester_filter)!='' || trim($acquirerauto)!='' || trim($companyauto)!='' ||  trim($sectorsearch)!='' ||  trim($advisorsearchstring_legal)!='' ||  trim($advisorsearchstring_trans)!='' )){
     
     $searchList=$invester_filter.$acquirerauto.$companyauto.str_replace("'","",trim($sectorsearch)).$advisorsearchstring_legal.$advisorsearchstring_trans;
     $searchList = explode(',', $searchList);
     $count=0;
     if($invester_filter !=''){
         $filed_name = 'investor';
     }else if($companyauto !=''){
         $filed_name = 'company';
     }
     ?>   
       $('.other_db_search').css('margin-top','50px');                                      
       $('.other_db_search').fadeIn();   
       $('.other_db_searchresult').html('');
       var href='';
     <?php  
     foreach ($searchList as $searchtext) {
         $searchallfield = trim($searchtext);
     
         $count++;
  ?>    
       console.log('<?php echo$searchallfield;?>');                                   
       var link ="gmail_like_search.php?section=<?php echo $section;?>-not&search=<?php echo$searchallfield;?>&filed_name=<?php echo $filed_name; ?>";                                   
       var text = 'Click here to search';  
       
        href += '<div class="refine_to_global"> "<?php echo $searchallfield?>" - <a class="refine_to_global_link" style="text-decoration: none;font-family: sans-serif" href="'+link+'" id="refinesearch_<?php echo$count?>" >'+text+'</a><div class="other_db_searchresult refinesearch_<?php echo$count?>" style="font-weight: normal;"></div><div>';
     
 <?php } ?> 

  $('.other_db_searchresult').html('<b style="font-size:16px">Search in other databases</b><br><br><br>'+href);
  
  
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
 
$(".other_db_search").on('click', '.other_db_link', function() {

        var search_val = $(this).attr('data-search_val');
        $('#all_keyword_other').val(search_val);
  });
  });
 
     // T960 Start ----------------------------------------------->
     $(document).on('click','#agreebtn-filter',function(){
                if($('.exportcheck:checked').length == 0){
                    alert('Please select minimum one field');
                    return false;
                }
                $('#popup-box-copyrights').fadeOut();   
                $('#maskscreen').fadeIn();
                $('#preloading').fadeIn();  
                $('#popup-box-copyrights-filter').fadeIn(); 
                
            });
            $(document).on('click','#expcancelbtn-filter',function(){

                jQuery('#popup-box-copyrights-filter').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
                $('#preloading').fadeOut();
                return false;
            });
            $(document).on('click','#agreebtn',function(){
                $('#popup-box-copyrights-filter').fadeOut();   
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
        // T960 End ------------------------------------------------------>
 
    // $(document).on('click','#agreebtn',function(){
        
    //     $('#popup-box-copyrights').fadeOut();   
    //     $('#maskscreen').fadeOut(1000);
    //     $('#preloading').fadeIn();   
    //     initExport();
    //     return false; 
    //  });
    
    //  $(document).on('click','#expcancelbtn',function(){

    //     jQuery('#popup-box-copyrights').fadeOut();   
    //     jQuery('#maskscreen').fadeOut(1000);
    //     return false;
    // });

    </script>
    <?php
    mysql_close();
    mysql_close($cnx);
    ?>

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
        width:25%;
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
        margin: auto;
        width: 50%;
    }
    </style>
   