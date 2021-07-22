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
        $_POST['investorauto']="";
        $_POST['companysearch'] = "";
        $_POST['companyauto']="";
        $_POST['industry']="";
        $_POST['statusid']="";
        $_POST['txtfirmtype']="";
        $_POST['followonFund']="";
        $_POST['txtregion']="";
        $_POST['citysearch']="";
        $_POST['yearafter']="";
        $_POST['yearbefore']="";
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

    function emptyhiddendata(){
            $_POST['total_inv_deal']="";
            $_POST['total_inv_amount']="";
            $_POST['total_inv_inr_amount']="";
            $_POST['total_inv_company']="";
        }

                $drilldownflag=0;
                $companyId=632270771;
                $companyIdDel=1718772497;
                $companyIdSGR=390958295;//688981071;//
                $companyIdVA=38248720;
                $companyIdGlobal=730002984;
                require_once("../dbconnectvi.php");
                $Db = new dbInvestments();
                $videalPageName="Inc";     
                 include ('checklogin.php');
                $searchString="Undisclosed";
                $searchString=strtolower($searchString);
                $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : 6; 
                $VCFlagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : 6; 
                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);
                $totalDisplay="";

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
            
               // print_r($_POST);
                
                $resetfield=$_POST['resetfield'];
                $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
                                                                where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
                
                if($trialrs=mysql_query($TrialSql))
                {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                                $compId=$trialrow["DCompId"];
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
                
                
                  
                if($resetfield=="searchallfield")
                { 
                 $_POST['searchallfield']="";
                 $searchallfield="";emptyhiddendata();
                }
                else 
                {
                if(isset($_POST['searchallfield']) && trim($_POST['searchallfield']) !=''){
                     $searchallfield=trim($_POST['searchallfield']);
                }
                if($searchallfield != "")
                        {
                            $_POST['keywordsearch'] = "";  $_REQUEST['investorauto']="";
                            $_POST['companysearch'] = "";   $_REQUEST['companyauto']="";$_POST['tagsearch']="";
                        }
                }
                $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                if($resetfield=="keywordsearch")
                { 
                 $_POST['keywordsearch']="";
                 $_POST['investorauto_sug_other']="";
                 $_POST['investorauto'] = $_POST['keywordsearch_other']="";
                 $keyword="";
                 $keywordhidden="";
                  $investorauto='';emptyhiddendata();
                }
                else 
                {
                $keyword1=trim($_POST['keywordsearch']);
            if(isset($_POST['investorauto_sug_other'])){
                $investorauto=$_POST['keywordsearch_other'];
                if($_POST['keyword']!=''){ $keyword=$_POST['keyword']; }else{
                $keyword=trim($_POST['investorauto_sug_other']);
                }
                $keywordsearch = $_POST['investorauto_sug_other'];
                $keywordhidden=ereg_replace(" ","_",$keyword);
                $month1=01; 
                $year1 = 1998;
                
                $month2= date('n');
                $year2 = date('Y');
            }else if(isset($_POST['investorauto'])){
                $investorauto=$_POST['investorauto'];
                $keywordsearch = $keyword=trim($_POST['keywordsearch']);
                $keywordhidden=trim($_POST['investorauto']);
            }else{
                $keywordsearch = $investorauto = $keyword=$keywordhidden='';
                $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] :  date('Y', strtotime(date('Y')." -1  Year"));
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');

            }
              $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
                 
                 
                }
                $keywordhidden =ereg_replace(" ","_",$keywordhidden);
                
                
                if($resetfield=="companysearch")
                { 
                 $_POST['companysearch']="";
                 $companysearch="";emptyhiddendata();
                  $companyauto='';
                }
                else 
                {
                    if($_POST['companyauto_sug']!=''){
                        $companysearch = $_POST['companyauto_sug'];
                          $companyauto = $_POST['companysearch'];
                        }else{
                            $companysearch=trim($_POST['companysearch']);
                            $companyauto=$_POST['companyauto'];
                          }   
            
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
                
                if($resetfield=="industry")
                { 
                 $_POST['industry']="";
                 $industry="";emptyhiddendata();
                }
                else 
                {
                 $industry=trim($_POST['industry']);
                }
                
                if($resetfield=="statusid")
                { 
                 $_POST['statusid']="";
                 $status="--";emptyhiddendata();
                }
                else 
                {
                 $status=trim($_POST['statusid']);
                }
                
                  if($resetfield=="txtfirmtype")
                { 
                 $_POST['txtfirmtype']="";
                 $incfirmtype="";emptyhiddendata();
                }
                else 
                {
                 $incfirmtype=trim($_POST['txtfirmtype']);
                }
               
                 if($resetfield=="chkDefunct")
                { 
                  $_POST['chkDefunct']="";
                  $defunctflag=1;
                  $addDefunctqry="";emptyhiddendata();
                }
                else 
                {
                  $defunctflag=0;
                  $addDefunctqry=" and Defunct=0 ";
                 
                }
                
                if($resetfield=="followonFund")
                { 
                 $_POST['followonFund']="";
                 $followon="";emptyhiddendata();
                }
                else 
                {
                 $followon=trim($_POST['followonFund']);
                }
                
                 if($resetfield=="txtregion")
                { 
                 $_POST['txtregion']="";
                 $regionId="";emptyhiddendata();
                }
                else 
                {
                 $regionId=trim($_POST['txtregion']);
                }
                if($resetfield=="city")
                { 
                    $_POST['citysearch']="";
                    $city="";emptyhiddendata();
                }
                else 
                {
                    $city=trim($_POST['citysearch']);
                    if($city != NULL){
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
                    emptyhiddendata();
                   
                }
                else 
                {
                    $yearafter=trim($_POST['yearafter']);
                    $yearbefore=trim($_POST['yearbefore']);
                    if( $yearafter !='' || $yearbefore !=''){
                        $searchallfield='';
                    }

                }
               
                //--------------------------------Date start-----------------------------------------------
                if (isset($_POST['period_flag'])) {
                    $period_flag = $_POST['period_flag'];
                } else {
                    $period_flag = 1;
                }
                
                if($resetfield=="period")
                {
                    $datefilter=''; 
                    $_POST['month1']="";
                    $_POST['year1']="";
                    $_POST['month2']="";
                    $_POST['year2']="";
                    
                    $month1='';
                    $year1='';
                    $month2='';
                    $year2='';
                    
                    //
                    
                    $month1=date('m');
                    $year1=date('Y')-1;
                    $month2=date('m');
                    $year2=date('Y');
                    
                    $getdt1 =  $year1."-".$month1."-01";
                    $getdt2 =  $year2."-".$month2."-31";                    
                    $datefilter=" date_month_year between '" . $getdt1. "' and '" . $getdt2 . "' AND  ";
                    
                     $sdatevalueDisplay1 = returnMonthname($month1) ." ".date('y', strtotime($getdt1));
                    $edatevalueDisplay2 = returnMonthname($month2) ."  ".date('y', strtotime($getdt2));
                    
                    
                    //
                    
                }
                elseif($_POST['searchallfield_other']!=""||trim($_POST['searchallfield'])!="" || trim($_POST['searchTagsField'])!="" || trim($_POST['keywordsearch'])!="" ||  trim($_POST['companysearch'])!=""  )
                {
                    
                 if($_POST['searchallfield_other']!=""){
                    $month1=01; 
                    $year1 = 1998;
                    $month2=date('m');
                    $year2=date('Y');
                 }elseif(!isset($_POST['month1'])|| $period_flag==2){
                     $month1=$_POST['month1'];
                    $year1=$_POST['year1'];
                    $month2=date('m');
                    $year2=date('Y');
                 }else{
                    $month1=01; 
                    $year1 = 1998;
                    $month2=$_POST['month2'];
                    $year2=$_POST['year2'];                     
                 }
                    $getdt1 =  $year1."-".$month1."-01";
                    $getdt2 =  $year2."-".$month2."-31";                    
                    $datefilter=" date_month_year between '" . $getdt1. "' and '" . $getdt2 . "' AND  ";
                    
                    $sdatevalueDisplay1 = returnMonthname($month1) ." ".date('y', strtotime($getdt1));
                    $edatevalueDisplay2 = returnMonthname($month2) ."  ".date('y', strtotime($getdt2));
                }elseif ( ($_POST['industry']!="--") || ($_POST['statusid']!="--") || ($_POST['txtfirmtype']!="--") || ($_POST['followonFund']!="--")
                        || ($_POST['txtregion']!="") || ($_POST['citysearch']!=""  || $_POST['tagsearch']!=''))
                {
                  
                    if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                        
                    if($period_flag == 2){
                        $month1 = $_POST['month1'];
                        $year1 = $_POST['year1'];
                    } else {
                        $month1=01;
                        $year1 = 1998;
                    }
                        // $month1 = $_POST['month1']; 
                        // $year1 = $_POST['year1'];
                        $month2= date('n');
                        $year2 = date('Y');
                            
                    }else{

                        $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                    }
                    
                    $getdt1 =  $year1."-".$month1."-01";
                    $getdt2 =  $year2."-".$month2."-31";                    
                    $datefilter=" date_month_year between '" . $getdt1. "' and '" . $getdt2 . "' AND  ";

                    $sdatevalueDisplay1 = returnMonthname($month1) ." ".date('y', strtotime($getdt1));
                    $edatevalueDisplay2 = returnMonthname($month2) ."  ".date('y', strtotime($getdt2));
                    //echo $sdatevalueDisplay1;
                }
                else{
                    $datefilter='';
                   
                    $month1=date('m');
                    $year1=date('Y')-1;
                    $month2=date('m');
                    $year2=date('Y');
                    
                    $getdt1 =  $year1."-".$month1."-01";
                    $getdt2 =  $year2."-".$month2."-31";                    
                    $datefilter=" date_month_year between '" . $getdt1. "' and '" . $getdt2 . "' AND  ";
                    
                    $sdatevalueDisplay1 = returnMonthname($month1) ." ".date('y', strtotime($getdt1));
                    $edatevalueDisplay2 = returnMonthname($month2) ."  ".date('y', strtotime($getdt2));
                    
                }
                
              //--------------------------------Date start-----------------------------------------------  
                
                
                $whereind="";
                $wherestatus="";
                if($industry >0)
                {
                    $industrysql= "select industry from industry where IndustryId=$industry";
                    if ($industryrs = mysql_query($industrysql))
                    {
                            While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                            {
                                    $industryvalue=$myrow["industry"];
                            }
                    }
                }
        if($status >0)
        {
        $statussql= "select StatusId,Status from incstatus where StatusId=$status";
            if ($stagers = mysql_query($statussql))
            {
                While($mysrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                {
                    $statusvalue=$mysrow["Status"];
                }
            }
        }
        if($incfirmtype >0)
        {
            $incfirmsql= "select IncFirmTypeId,IncTypeName from incfirmtypes where IncFirmTypeId=$incfirmtype";
            if ($incrs = mysql_query($incfirmsql))
                {
                        While($myincrow=mysql_fetch_array($incrs, MYSQL_BOTH))
                        {
                                $inctype=$myincrow["IncTypeName"];
                        }
                }
        }
        if($defunctflag==1)
                {   $defunctText= "Excluded Defunct Cos"; }
                else
                {     $defunctText= "Included Defunct Cos"; }
        if($regionId >0)
            {
            $regionSql= "select Region from region where RegionId=$regionId";
                    if ($regionrs = mysql_query($regionSql))
                    {
                        While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
                        {
                            $regionvalue=$myregionrow["Region"];
                        }
                    }
        }

                $addVCFlagqry = " and pec.industry !=15 ";
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
                
                $addDelindhidden=$addDelind;
                $searchTitle = "Incubated Companies";
                $dateorder="";$orderby=""; $ordertype="";
                
                
                if(isset($_REQUEST['searchallfield_other'])){
                    
                $searchallfield=$_REQUEST['searchallfield_other'];
               $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                                $month1=01; 
                                $year1 = 1998;
                                $month2= date('n');
                                $year2 = date('Y');
                                $getdt1 =  $year1."-".$month1."-01";
                                $getdt2 =  $year2."-".$month2."-31"; 
                    
                    $datefilter=" date_month_year between '" . $getdt1. "' and '" . $getdt2 . "' AND ";
                }
                
                if(!$_POST || $companysearch != ""|| $keyword !="") {
                    $industry = '--';
                    $status="--";
                    $defunctflag = 0;
                    $incfirmtype='';
                    $regionId = 0;
                    $incfirmtype = 0;
                    $industryvalue = '';
                    $followon = '--';
                    $followonFund = '--';
                }    
                
                // if($resetfield=="tagsearch")
                // { 
                //     $_POST['tagsearch']="";
                //     $tagsearch="";
                // }
                // elseif($_POST['tagsearch']  && $_POST['tagsearch'] !=''){

                //     $tagsearch="tag:".trim($_POST['tagsearch']);
                // }else if(isset($_POST['searchTagsField']) && trim($_POST['searchTagsField']) !=''){
                //     $tagsearch=trim($_POST['searchTagsField']);
                //     $_POST['tagsearch'] = $_POST['searchTagsField'];
                // }

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

                    /*$_POST['tagsearch']="";
                    $_POST['tagsearch_auto'] = "";
                    $tagsearch = "";
                    $tagandor=0;*/
                   
                } else if($_POST['tagsearch_auto']  && $_POST['tagsearch_auto'] !='' || $_POST['tagsearch'] != '') {
                    
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
                } else if(isset($_POST['searchTagsField']) && trim($_POST['searchTagsField']) !=''){
                    $tagsearch=trim($_POST['searchTagsField']);
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

                if($followon=="--")
                    $followonFund="--";
                    $followonFundText="";
                if($followon==1){
                    $followonFund='1';
                    $followonFundText="Follow on Funding";
                } elseif($followon==2){
                    $followonFund='0';
                    $followonFundText="No Funding";
                }
                
                if($_SESSION['PE_industries']!=''){

                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                
                if(!$_POST)
                {
                    $iftest=1;
                    $yourquery=0;
                    $companysql = "SELECT pe.IncDealId,pe.IncubateeId,pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,Individual,inc.Incubator,pec.PECompanyid as companyid, pe.date_month_year 
                                        FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,incubators as inc 
                                        WHERE $datefilter pec.industry = i.industryid   and inc.IncubatorId=pe.IncubatorId 
                                        AND pec.PEcompanyID = pe.IncubateeId  and pe.Deleted=0 ". $comp_industry_id_where .$addVCFlagqry.$addDefunctqry." ".$addDelind;
                    $dateorder="date_month_year desc";
                    $orderby="companyname";
                    $ordertype="asc";
                     //echo "<br>all records" .$companysql;
                }elseif(count($_POST)==0)    
        {

                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $iftest=1;
                        $yourquery=0;
                        $companysql = "SELECT pe.IncDealId,pe.IncubateeId,pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,Individual,inc.Incubator,pec.PECompanyid as companyid, pe.date_month_year 
                                        FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,incubators as inc 
                                        WHERE $datefilter pec.industry = i.industryid   and inc.IncubatorId=pe.IncubatorId 
                                        AND pec.PEcompanyID = pe.IncubateeId  and pe.Deleted=0 ";

                        if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                        {
                                $qryDateTitle ="Period - ";
                                $wheredates= " date_month_year between '" . $dt1. "' and '" . $dt2 . "'";
                        }
                        if(($wheredates != "") )
                        {
                                $companysql = $companysql . $wheredates ." and ";
                                $aggsql = $aggsql . $wheredates ." and ";
                                $bool=true;
                        }
                        $companysql = $companysql . $comp_industry_id_where .$addVCFlagqry.$addDefunctqry." ".$addDelind;
                        $dateorder="date_month_year desc";
                        $orderby="companyname";
                        $ordertype="asc";
                       // echo $companysql;

                }
        
                elseif($tagsearch!="")
                {
                    $iftest=4;
                    $yourquery=1;

                    $tags = '';
                    $ex_tags = explode(',',$tagsearch);
                    if(count($ex_tags) > 0){
                        for($l=0;$l<count($ex_tags);$l++){
                            if($ex_tags[$l] !=''){
                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                $value = str_replace(" ","",$value);
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
                        
                    $companysql="SELECT pe.IncDealId, pe.IncubateeId,pec.companyname, pec.industry, i.industry, pec.sector_business  as sector_business,
                    Individual,inc.Incubator,pec.AdCity,pec.PECompanyid as companyid, pe.date_month_year
                    FROM incubatordeals AS pe, industry AS i,pecompanies AS pec,incubators as inc
                    WHERE $datefilter  pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and  inc.IncubatorId=pe.IncubatorId
                    AND pe.Deleted =0 ". $comp_industry_id_where .$addVCFlagqry .$addDefunctqry.  " ".$addDelind."  AND ( $tagsval ) "; 
                    $dateorder="date_month_year desc";
                    $orderby="companyname";
                    $ordertype="asc";
                    //echo "<bR>---" .$companysql;
                }
                elseif($searchallfield!="")
                {
                        $iftest=4;
                        $yourquery=1;
                        
                            /*$tagsval = "pec.AdCity LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' or sector_business LIKE '$searchallfield%' or MoreInfor LIKE '%$searchallfield%'  or Incubator LIKE '%$searchallfield%' or pec.tags like '%$searchallfield%'";*/
                            $searchExplode = explode( ' ', $searchallfield );
                            foreach( $searchExplode as $searchFieldExp ) {
                      /* $cityLike .= "pec.AdCity LIKE '$searchallfield%' AND ";
                                $companyLike .= "pec.companyname LIKE '%$searchallfield%' AND ";
                                $sectorLike .= "sector_business LIKE '$searchallfield%' AND ";
                                $moreInfoLike .= "MoreInfor LIKE '%$searchallfield%' AND ";
                                $incubatorLike .= "Incubator LIKE '%$searchallfield%' AND ";
                                $industryLike .= "i.industry LIKE '%$searchallfield%' AND ";
                        $websiteLike .= "pec.website LIKE '%$searchallfield%' AND ";*/

                        $cityLike .= "pec.AdCity REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $incubatorLike .= "Incubator REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $industryLike .= "i.industry REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                        $websiteLike .= "pec.website REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                        $tagsLike .= "(pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,') and ";
                            }
                            $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                            $cityLike = '('.trim($cityLike,'AND ').')';
                            $companyLike = '('.trim($companyLike,'AND ').')';
                            $sectorLike = '('.trim($sectorLike,'AND ').')';
                            $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
                            $incubatorLike = '('.trim($incubatorLike,'AND ').')';
                            $industryLike = '('.trim($industryLike,'AND ').')';
                            $websiteLike = '('.trim($websiteLike,'AND ').')';
                    $tagsLike = '('.trim($tagsLike,'AND ').')';
                            $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $incubatorLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;                                    
                        
                        $companysql="SELECT pe.IncDealId, pe.IncubateeId,pec.companyname, pec.industry, i.industry, pec.sector_business  as sector_business,
                                        Individual,inc.Incubator,pec.AdCity,pec.PECompanyid as companyid, pe.date_month_year
                                        FROM incubatordeals AS pe, industry AS i,pecompanies AS pec,incubators as inc
                                        WHERE $datefilter pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and  inc.IncubatorId=pe.IncubatorId
                                        AND pe.Deleted =0 ". $comp_industry_id_where .$addVCFlagqry .$addDefunctqry.  " ".$addDelind."  AND ( $tagsval ) "; 
                        $dateorder="date_month_year desc";
                        $orderby="companyname";
                        $ordertype="asc";
                        //echo "<bR>---" .$companysql;
                }
                elseif ($companysearch!="")
                {
                    $companyval=$companysearch;
                        $iftest=2;
                        $yourquery=1;
                        $companysql="SELECT pe.IncDealId,pe.IncubateeId, pec.companyname, pec.industry, i.industry, pec.sector_business  as sector_business,
                                        Individual,inc.Incubator,pec.PECompanyid as companyid, pe.date_month_year
                                        FROM incubatordeals AS pe, industry AS i,  pecompanies AS pec,incubators as inc
                                        WHERE $datefilter pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and inc.IncubatorId=pe.IncubatorId
                                        AND pe.Deleted =0 ". $comp_industry_id_where .$addVCFlagqry.$addDefunctqry. " ".$addDelind." AND    pec.PECompanyId IN ($companysearch)   ";
                        $dateorder="date_month_year desc";
                        $orderby="companyname";
                        $ordertype="asc";
                        //  echo "<br>Query for company search";
                       // echo "<br> Company search--" .$companysql;
                }
                elseif($keyword!="")
                {
                    $ex_investorauto = explode(',', $investorauto);
                    $investSql = array();
                    for($k=0;$k<count($ex_investorauto);$k++){
                        $invest = trim($ex_investorauto[$k]);
                        if($invest !=''){
                            $investSql[] = "inc.Incubator like '$invest'";
                        }                        
                    }
                    $investSql = implode(" or ", $investSql);
                    $iftest=3;
                    $yourquery=1;
                    $companysql="select pe.IncDealId,pe.IncubateeId,pec.companyname,pec.industry,i.industry,pec.sector_business  as sector_business,Individual,
                                        pe.IncubatorId,inc.Incubator,pec.PECompanyid as companyid , pe.date_month_year
                                        from incubatordeals as pe,pecompanies as pec,industry as i ,incubators as inc 
                                        where $datefilter pec.industry = i.industryid and  inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 
                                        and pec.PECompanyId=pe.IncubateeId ". $comp_industry_id_where .$addVCFlagqry.$addDefunctqry. " ".$addDelind." AND ( $investSql ) ";
                    $dateorder="date_month_year desc";
                    $orderby="companyname";
                    $ordertype="asc";
                        //echo "<br> Investor search- ".$companysql;
                }
                elseif (($industry!="") || ($status !="")|| ($followonFund !="")|| ($regionId!="") || ($incfirmtype>0) || ($yearafter != "") || ($yearbefore != ""))
                {
                    // echo "<br>--" .$regionId;
                    $iftest=5;
                    $yourquery=1;
                    $companysql = "select pe.IncDealId,pe.IncubateeId,pec.companyname,pec.industry,i.industry,pec.sector_business  as sector_business,Individual,inc.Incubator,pec.PECompanyid as companyid, pe.date_month_year
                                    from incubatordeals as pe, industry as i,pecompanies as pec,incubators as inc,region as r where $datefilter";
                    //  echo "<br> individual where clauses have to be merged ";
                    if ($industry > 0 && $industry != '--')
                    {
                            $whereind = " pec.industry=" .$industry ;
                            $qryIndTitle="Industry - ";
                    }
                    if ($status> 0)
                    {
                            $wherestatus = " pe.StatusId =" .$status ;
                            $qryDealTypeTitle="Stage  - ";
                    }
                    if($incfirmtype>0)
                    {
                      $wherefirmtype=" inc.IncFirmTypeId=".$incfirmtype;
                      $qryFirmType="Firm Type - ";
                    }
                    if (($followonFund =="0") || ($followonFund=="1"))
                    {
                        $wherefollowonFund = " pe.FollowonFund = ".$followonFund;
                        $qryDealTypeTitle="Follow on Funding Status  - ";
                    }
                    if ($regionId> 0)
                    {
                            $whereregion = " pec.RegionId =" .$regionId ;
                            $qryregionTitle="Region  - ";
                    }
                    if($city != "")
                    {
                        $whereCity=" pec.city LIKE '".$city."%'";
                    }
                    if ($whereind != "")
                    {
                            $companysql=$companysql . $whereind ." and ";
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
                    if (($wherestatus != ""))
                    {
                        $companysql=$companysql . $wherestatus . " and " ;
                    }
                    if($wherefirmtype!="")
                    {
                        $companysql=$companysql . $wherefirmtype . " and " ;
                    }
                    if (($whereregion != ""))
                    {
                        $companysql=$companysql . $whereregion . " and " ;
                    }
                    if($whereCity !="")
                    {
                        $companysql=$companysql.$whereCity." and ";
                    }
                    if($wherefollowonFund!="")
                         $companysql=$companysql .$wherefollowonFund. " and ";

                    $companysql = $companysql . "  i.industryid=pec.industry and
                                    pec.PEcompanyID = pe.IncubateeId and inc.IncubatorId=pe.IncubatorId and  r.RegionId=pec.RegionId
                                    and pe.Deleted=0 ". $comp_industry_id_where .$addVCFlagqry .$addDefunctqry." ".$addDelind ;
                    $dateorder="date_month_year desc";
                    $orderby="companyname";
                    $ordertype="asc";
                    //echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                }
                else
                {
                    $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $iftest=1;
                        $yourquery=0;
                        $companysql = "SELECT pe.IncDealId,pe.IncubateeId,pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,Individual,inc.Incubator,pec.PECompanyid as companyid, pe.date_month_year 
                                        FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,incubators as inc 
                                        WHERE $datefilter pec.industry = i.industryid   and inc.IncubatorId=pe.IncubatorId 
                                        AND pec.PEcompanyID = pe.IncubateeId  and pe.Deleted=0 ";

                        if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                        {
                                $qryDateTitle ="Period - ";
                                $wheredates= " and date_month_year between '" . $dt1. "' and '" . $dt2 . "'";
                        }
                        if(($wheredates != "") )
                        {
                                $companysql = $companysql . $wheredates ." ";
                                //$aggsql = $aggsql . $wheredates ." and ";
                               // $bool=true;
                        }
                        $companysql = $companysql . $comp_industry_id_where .$addVCFlagqry.$addDefunctqry." ".$addDelind;
                        $dateorder="date_month_year desc";
                        $orderby="companyname";
                        $ordertype="asc";
                        //echo "<br> Invalid input selection ";
                        $fetchRecords=false;
                }
        $ajaxcompanysql=  urlencode($companysql);
        if($companysql!="")
           $companysql = $companysql . " order by ".$dateorder.", ".$orderby." ".$ordertype ; 
        $topNav = 'Deals';
    include_once('incheader_search.php');
    ?>

<div id="container">
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
 <td class="left-td-bg" >
     <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">

           <?php include_once('increfine.php');?>
           <input type="hidden" name="resetfield" value="" id="resetfield"/>    
           <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>
        </div>
    </div>
</td>
    <?php
            $exportToExcel=0;
            $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
                                                                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
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
            $totalInv=0;
            
            $cos_array=array();
            if($_SESSION['coscount']){ unset($_SESSION['coscount']); }
            
            $compDisplayOboldTag="";
            $compDisplayEboldTag="";
            
            //   echo $companysql;
            if ($companyrsall = mysql_query($companysql))
            {
                $company_cntall = mysql_num_rows($companyrsall);
                While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                {
                        $cos_array[]=$myrow["companyid"];
            } 
            } 
            
             $_SESSION['coscount'] = $comp_count = count(array_count_values($cos_array));
   
            if($company_cntall > 0)
            {
                if($searchallfield!=''){
                                
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
                if($searchallfield!=''){
                                
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
                $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                $notable=true;
            }
           ?>     
    <td class="profile-view-left" style="width:100%;">
    <div class="result-cnt" style="margin-bottom: 30px;">
        <?php if ($accesserror==1){?>
                    <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
        <?php
                exit; 
                } 
        ?>
        <div class="result-title">
             <div class="filter-key-result">
                 <div class="lft-cn">
                    <?php if(!$_POST)
                            {   
                                ?>
                                          
                            <ul class="result-select">
                            <?php if($datefilter!=""){ ?>
                               <li>
                                   <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?> <a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                               </li>
                               <?php }
                               ?>
                            </ul>    
                        <?php 
                        }
                        else 
                        {
                         if(($industry >0 && $industry!=null)||($status>0)||($defunctflag==0)||($incfirmtype >0)|| ($followonFund!="--" && $followonFund!="")||($regionId>0)||($keyword!=" " && $keyword!="")||($companysearch!=" " && $companysearch!="")||($searchallfield!="")||($datefilter!="") || ($yearafter != "") || ($yearbefore != "")){ $cls="mt-list-tab"; ?>
                                
                             <ul class="result-select">
                                    <?php
                                     $cl_count = count($_POST);
                                     if($cl_count >= 4)
                                     {
                                     ?>
                                     <li class="result-select-close"><a href="incindex.php"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                     <?php
                                     }
                                    // echo "<bR>--**" .$followonVCFund."adsasd".$followonVCFundText;
                                     //echo $queryDisplayTitle;
                                   if($industry >0 && $industry!=null && $industry !='--'){ ?>
                                    <li><?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                                    <?php }
                                    if($status>0){ ?>
                                    <li>
                                        <?php echo $statusvalue; ?><a  onclick="resetinput('statusid');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } if($defunctflag==1){ ?>
                                    <li>
                                        <?php echo "Exclude Defunct Cos"; ?><a  onclick="resetinput('chkDefunct');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li> 

                                    <?php } if($incfirmtype >0){ ?>
                                    <li>
                                        <?php echo $inctype; ?><a  onclick="resetinput('txtfirmtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } 
                                    if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } 
                                    if($followonFund!="--" && $followonFund!="" && $followonFundText !=''){  ?>
                                    <li>
                                        <?php echo $followonFundText;?><a  onclick="resetinput('followonFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } if($regionId>0){ ?>
                                    <li>
                                        <?php echo $regionvalue;?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php }
                                    if($city!=""){ $drilldownflag=0; ?>
                                        <li> 
                                            <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                  <?php } 
                                    if($investorauto!=" " && $investorauto!=""){ ?>
                                    <li>
                                        <?php echo $investorauto?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } if($csearch!=""){ $drilldownflag=0; ?>
                                  <li> 
                                      <?php echo $company_filter;?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li>
                                  <?php }  if($searchallfield!=""){ ?>
                                    <li>
                                        <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } if($datefilter!=""){ ?>
                                    <li>
                                        <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?> <a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php }
                                      if($tagsearch!=''){ ?>
                                          <?php $tagarray = explode(",",$tagsearch); 
             foreach ($tagarray as $key=>$value){  ?>
                  <li>
                      <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?> 
                                    
                                  <!--   <li><?php echo "tag:".trim($tagsearch)?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
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
                                    
                                    ?>
                            </ul> 
                        <?php } 
                        }
                                
                        if( $peEnableFlag ) {
                            if( empty( $pe_company ) ) {
                                $cos_array1  = '';
                                $comp_count = 0;
                            } else {
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
                       
                                 //========================================junaid==========================================
                                    foreach(array_count_values($cos_array) as $key=>$value){
                                        $company_array[]=$key;
                                    }
                                    $comp_count = count(array_count_values($cos_array));
                                    $company_array_comma = implode(",",$company_array); // junaid
                                //=========================================================================================
                        ?>
                </div>
                <div class='result-rt-cnt'>
                     <div class="result-count" >
                         
                                <?php if(!$_POST){   
                                
                                if($studentOption==1)
                                {
                                ?>
                                    <!--  <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' ){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!='' ){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span>   -->
                                     <span class="result-no"><span class="res_total"><?php if($totalInv!=''){ echo $totalInv;  }else{ echo $_POST['total_inv_deal']; } ?></span> Results Found (across <span class="comp_total"><?php if($comp_count!='' ){ echo $comp_count;  }else{ echo $_POST['total_inv_company']; }?></span> cos)</span>  

                                 <?php
                                }
                                else
                                {
                                     ?> 
                                           <!-- <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!='' ){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span>  -->
                                            <span class="result-no"><span class="res_total"><?php if($totalInv!=''){ echo $totalInv;  }else{ echo $_POST['total_inv_deal']; } ?></span> Results Found (across <span class="comp_total"><?php if($comp_count!='' ){ echo $comp_count;  }else{ echo $_POST['total_inv_company']; }?></span> cos)</span> 
                                     <?php
                                }
                                ?>  
                                <!-- <span class="result-for" style="margin-right: 10px;">  for Incubation Investments</span> -->
                                <span class="result-for" style="margin-right: 10px;"></span>
                                <input class="postlink" type="hidden" name="numberofcom" value="<?php echo @mysql_num_rows($companyrs); ?>">
                                <div class="title-links " id="exportbtn"></div>       
                                <?php 
                                    $instyle='style="margin-top: 68px !important;"';
                                }else { 
                                    
                                    if($studentOption==1){ 
                                    ?>
                                       <!--  <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!='' ){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!='' ){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span>   -->
                                        <span class="result-no"><span class="res_total"><?php if($totalInv!=''){ echo $totalInv;  }else{ echo $_POST['total_inv_deal']; } ?></span> Results Found (across <span class="comp_total"><?php if($comp_count!='' ){ echo $comp_count;  }else{ echo $_POST['total_inv_company']; }?></span> cos)</span>
                                <?php }else{ ?> 
                                        <!-- <span class="result-no"><span class="res_total"><?php if($_POST['total_inv_deal']!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?></span> Results Found (across <span class="comp_total"><?php if($_POST['total_inv_company']!=''){ echo $_POST['total_inv_company']; }else{ echo $comp_count; }?></span> cos)</span>  -->
                                         <span class="result-no"><span class="res_total"><?php if($totalInv!=''){ echo $totalInv;  }else{ echo $_POST['total_inv_deal']; } ?></span> Results Found (across <span class="comp_total"><?php if($comp_count!='' ){ echo $comp_count;  }else{ echo $_POST['total_inv_company']; }?></span> cos)</span> 
                                <?php } ?>  
                                    <span class="result-for" style="margin-right: 10px;">  for Incubation Investments</span>
                                    <input class="postlink" type="hidden" name="numberofcom" value="<?php echo @mysql_num_rows($companyrs); ?>">
                                    <div class="title-links " id="exportbtn"></div>
                                <?php } ?>
                     </div>
                </div>  
            </div>          
        </div>  
                    <?php if($notable==false){  
        
                if ($company_cntall>0)
                {
                      $hidecount=0;
                      //Code to add 
                      // /NEXT
                      $icount = 0;
                      if ($_SESSION['resultId']) 
                              unset($_SESSION['resultId']); 
                      if ($_SESSION['resultCompanyId']) 
                              unset($_SESSION['resultCompanyId']); 
                      mysql_data_seek($companyrsall,0);
                      While($myrow=mysql_fetch_array($companyrsall, MYSQL_BOTH))
                      {
                          $incubatorname=$myrow["Incubator"];
                          $companyName=trim($myrow["companyname"]);
                          $companyName=strtolower($companyName);
                          $compResult=substr_count($companyName,$searchString);
                          $compResult1=substr_count($companyName,$searchString1);
                          if(($compResult==0) && ($compResult1==0))
                          {
                              //Session Variable for storing Id. To be used in Previous / Next Buttons
                              $_SESSION['resultId'][$icount] = $myrow["IncDealId"]; 
                              $_SESSION['resultCompanyId'][$icount] = $myrow["companyid"];
                              $icount++;
                          }
                                //$totalInv=$totalInv+1;
                      }
              }
        ?>
        <a id="detailpost" class="postlink"></a>
        <div class="view-table view-table-list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                            <thead>
                                <tr>
                                    <?php if( $searchallfield != '' || $_POST['industry'] != '' || $_POST['statusid'] != "" || ($_POST['txtfirmtype'] != "" && $_POST['txtfirmtype'] != 0) || ($_POST['followonFund'] != "" && $_POST['followonFund'] != "--") || $_POST['txtregion'] != "" || $_POST['citysearch'] != "" || $investorauto != "" || $companyauto != "" || $tagsearch != ""|| $_POST['companysearch']!='' || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '') { 
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
                <th class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname" >Incubatee</th>
                <th class="header <?php echo ($orderby=="Incubator")?$ordertype:""; ?>" id="Incubator" >Incubator</th>
                <th class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                <th class="header <?php echo ($orderby=="date_month_year")?$ordertype:""; ?>" id="date_month_year">Date</th>

                                </tr>
                            </thead>
              
              <tbody id="movies">
                            <?php if ($company_cnt>0) {
                                
                                $hidecount=0;
                                $hideFlagset = 0;
                                //Code to add PREV /NEXT
                                mysql_data_seek($companyrs,0);
                                While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                {
                                    
                                    if($myrow["Individual"]==1)
                                    {
                                            $openBracket="(";
                                            $closeBracket=")";
                                            $hideFlagset = 1;
                                    }
                                    else
                                    {
                                            $openBracket="";
                                            $closeBracket="";
                                    }
                                    if(trim($myrow["sector_business"])=="")
                                            $showindsec=$myrow["industry"];
                                    else
                                            $showindsec=$myrow["sector_business"];
                                    
                                    $incubatorname=$myrow["Incubator"];
                                   
                                    $companyName=trim($myrow["companyname"]);
                                    $companyName=strtolower($companyName);
                                    $compResult=substr_count($companyName,$searchString);
                                    $compResult1=substr_count($companyName,$searchString1);

                                    
                                    if($myrow['date_month_year']!='0000-00-00'){
                                    $date = date('M-Y', strtotime($myrow['date_month_year']));
                                    }else{
                                    $date ='-';
                                    }
                                    
                                   /* if( $searchallfield != '' ) {

                                        if( !empty( $pe_checkbox ) ) {

                                              if( in_array( $myrow["IncDealId"], $pe_checkbox ) ) {
                                                  $peChecked = '';
                                                  $rowClass = 'event_stop';
                                              } else {
                                                  $peChecked = 'checked';
                                                  $rowClass = '';
                                              }
                                          } else {
                                            
                                              $peChecked = 'checked';
                                              $rowClass = '';
                                          }
                                    }*/
                                    
                                // ------------------------------------------junaid--------------------------------------------------
                                               
                                    if(count($pe_checkbox) > 0 && $pe_checkbox[0]!='' &&  count($pe_checkbox_enable) > 0 && $pe_checkbox_enable[0]!=''){

                                            if( (in_array( $myrow["IncDealId"], $pe_checkbox )) ) {
                                                    $checked = '';
                                                    $rowClass = 'event_stop';

                                      }
                                            elseif( (in_array( $myrow["IncDealId"], $pe_checkbox_enable )) ) {
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

                                            if( (in_array( $myrow["IncDealId"], $pe_checkbox )) ) {
                                                    $checked = '';
                                                    $rowClass = 'event_stop';

                                            }elseif($_POST['full_uncheck_flag']==1){
                                                $checked = '';
                                                $rowClass = 'event_stop';
                                            } else {
                                                    $checked = 'checked';
                                                    $rowClass = '';
                                            }

                                        }elseif( !empty( $pe_checkbox_enable ) && $pe_checkbox_enable[0]!=''){ //=========================junaid=================

                                            if( (in_array( $myrow["IncDealId"], $pe_checkbox_enable )) ) {
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
                                            ?>

                                <tr class="details_link <?php echo $rowClass; ?>" valueId="<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?>">
                                    <?php if( $searchallfield != '' || $_POST['industry'] != '' || $_POST['statusid'] != "" || ($_POST['txtfirmtype'] != "" && $_POST['txtfirmtype'] != 0) || ($_POST['followonFund'] != "" && $_POST['followonFund'] != "--") || $_POST['txtregion'] != "" || $_POST['citysearch'] != "" || $investorauto != "" || $companyauto != "" || $tagsearch != "" || $_POST['companysearch']!='' || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '') {  ?>
                                        <td><input type="checkbox" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow[ 'companyid' ]; ?>" class="pe_checkbox" <?php echo $checked; ?> value="<?php echo $myrow["IncDealId"];?>" /></td>
                                    <?php } 
                                    
                                    if(($compResult==0) && ($compResult1==0)){ ?>
                                                <td ><?php echo $openBracket ; ?><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?></td>
                                    <?php } else{ ?>
                                                <td><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo ucfirst("$searchString");?></a></td>
                                    <?php } ?>
                                                <td><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($incubatorname); ?></a></td>
                                                <td><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($showindsec); ?></a></td>
                                                <td><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($date); ?></a></td>

                                        </tr>
                                        <?php
                                        }
                                }
                                ?>
        </tbody>
    </table>
    </div>
        <input type="hidden" name="pe_checkbox_disbale" id="pe_checkbox_disbale" value="<?php echo implode( ',', $pe_checkbox ); ?>">
            <input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>"> 
        <input type="hidden" name="pe_checkbox_company" id="pe_checkbox_company" value="<?php echo implode( ',', $cos_array1 ); ?>">
        <!-- edited -->
        <!-- <input type="hidden" name="listallcompanies" class="listallcompanies" value=<?php echo $listallcompany; ?> > -->
        <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST['pe_hide_companies']; ?>">
        <input type="hidden" name="array_comma_company" id="array_comma_company" value="<?php echo $company_array_comma; ?>">
        
        <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php if($totalInv!=''){ echo $totalInv;  }else{ echo $_POST['total_inv_deal']; } ?>">
        <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php if($comp_count!='' ){ echo $comp_count;  }else{ echo $_POST['total_inv_company']; }?>">
        <input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php if($_POST['total_inv_deal']!=''){ echo $_POST['total_inv_deal']; }else{  echo $totalInv; }?>">
        <input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php if($_POST['total_inv_company']!=''){ echo $_POST['total_inv_company']; }else{  echo $comp_count; }?>">
        <input type="hidden" name="all_checkbox_search" id="all_checkbox_search" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
        <!-- end  -->
        <?php
             if( $searchallfield != '' || $_POST['industry'] != '' || $_POST['statusid'] != "" || ($_POST['txtfirmtype'] != "" && $_POST['txtfirmtype'] != 0) || ($_POST['followonFund'] != "" && $_POST['followonFund'] != "--") || $_POST['txtregion'] != "" || $_POST['citysearch'] != "" || $investorauto != "" || $companyauto != "" || $tagsearch != "") {  ?>
              
                <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php if($_POST['real_total_inv_deal']!=''){ echo $_POST['real_total_inv_deal']; }else{ echo $totalInv; } ?>">
                <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php if($_POST['real_total_inv_company']!=''){ echo $_POST['real_total_inv_company']; }else{ echo $comp_count; } ?>">
                
                <input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php if($_POST['total_inv_deal']!=''){ echo $_POST['total_inv_deal']; }else{  echo $totalInv; }?>">
                <input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php if($_POST['total_inv_company']!=''){ echo $_POST['total_inv_company']; }else{  echo $comp_count; }?>">
                <input type="hidden" name="all_checkbox_search" id="all_checkbox_search" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
                <input type="hidden" name="array_comma_company" id="array_comma_company" value="<?php echo $company_array_comma; ?>">
                
                <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST[ 'pe_hide_companies' ]; ?>">
                
           <?php } 
           
            } ?>
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
    <button class = "jp-page1 button pagevalue" name="pagination" id="pagination" type="submit" onclick = "validpagination()">Go</button></div>
    </center>

    <?php
                if($studentOption==1)
        {
        ?>
                     <script type="text/javascript" >
                           $("#show-total-deal").html('<?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?> (Results found)');
                    </script>
        
        <?php
        }
        else
        {

                    /*if($exportToExcel==1)
                    {*/
                    ?>
                        <script type="text/javascript" >
                         $("#show-total-deal").html('<?php if($_POST['total_inv_deal']!='' && $searchallfield!=''){ echo $_POST['total_inv_deal']; }else{ echo $totalInv; } ?> (Results found)');
                        </script>
                    <?php
                    /*}
                    else
                    {
                    ?>
                       <script type="text/javascript" >
                           $("#show-total-deal").html('XXX Results found ');
                       </script>
                       <br><div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
                    <?php
                    }*/
        }
                    
                            if(($totalInv>0) &&  ($exportToExcel==1))
                            {
                    ?>
                        <span style="float:right" class="one">
                        <a class="export_new" id="expshowdealsbt" name="showdeals">Export</a>
                        </span>
                        <script type="text/javascript">
                            $('#exportbtn').html('<a class ="export_new" id="expshowdeals"  name="showdeals">Export</a>');
                        </script>

                    <?php
                            }
                            elseif(($totalInv>0) && ($exportToExcel==0))
                            {
                    ?>
                            <div>
                             <span>
                                <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing PE investments.  </p>
                                <span style="float:right" class="one">
                                     <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                                <a class ="export" target="_blank" href="../xls/Sample_Sheet_Investments.xls"> Export Sample</a>
                                </span>
                                <script type="text/javascript">
                                            $('#exportbtn').html('<a class="export"  href="../xls/Sample_Sheet_Investments.xls">Export Sample</a>');
                                </script>
                             </span>
                            </div>

                    <?php
                            }
                ?>
        </div>
        <?php
                    }
                    elseif($buttonClicked=='Aggregate')
                    {

                        $aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                and  pe.Deleted=0 " .$addVCFlagqry.
                                     " order by pe.amount desc,dates desc";
                        //  echo "<br>Agg SQL--" .$aggsql;
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
                               if($industry >0)
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
                                 if($stage!="")
                               {
                                  $stageSql= "select Stage from stage where StageId=$stage";
                                  if($rsStage=mysql_query($stageSql))
                                  {
                                      while($mystageRow=mysql_fetch_array($rsStage,MYSQL_BOTH))
                                      {
                                        $stageqryValue=$mystageRow["Stage"];
                                      }
                                   }
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
                                    $rangeqryValue= $rangeText;
                                }
                                if($wheredates !== "")
                                {
                                    $dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
                                }
                                $searchsubTitle="";
                                if(($industry==0) && ($stage=="--") && ($range=="--") && ($wheredates==""))
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
                        if($stage !="")
                        {
                    ?>
                            <?php echo $qryDealTypeTitle; ?><?php echo $stageqryValue; ?> <?php echo $spacing; ?>
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
        <?php 
        if( !isset( $_POST[ 'tagsfield' ] )) {
            include("inctag_report.php"); 
        }
          
        ?>
    </td>

    </tr>
    </table>

    </div>
    <div class=""></div>

     
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
                var full_check_flag =  $( '#all_checkbox_search' ).val();//junaid
                 var pecheckedVal = $( '#pe_checkbox_enable' ).val();//junaid
                jQuery('#preloading').fadeIn(1000);   
                $.ajax({
                type : 'POST',
                url  : 'ajaxListview_inc.php',
                data: {

                        sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                        totalrecords : '<?php echo addslashes($company_cntall); ?>',
                        page: pageno,
                        vcflagvalue:'<?php echo $vcflagValue; ?>',
                        orderby:orderby,
                        ordertype:ordertype,
                        searchField: '<?php echo $searchallfield; ?>',
                        industry: '<?php echo $industry; ?>',
                        status: '<?php echo $status; ?>',
                        incfirmtype: '<?php echo $incfirmtype; ?>',
                        followon: '<?php echo $followon; ?>',
                        regionId: '<?php echo $regionId; ?>',
                        city: '<?php echo $city; ?>',
                        investor: '<?php echo $investorauto_sug_other; ?>',
                        company: '<?php echo $companysearch_other; ?>',
                        tagsearch: '<?php echo $tagsearch; ?>',

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
                
                    var peuncheckCompdId = $( event.target ).val();
                    var peuncheckCompany = $( event.target ).data( 'company-id' );
                    pehideFlag = $(event.target).data('hide-flag');
                    var total_invdeal = $("#real_total_inv_deal").val(); //junaid
                    var total_invcompany = $("#real_total_inv_company").val();//junaid
                    
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
                        updateCountandAmount( 'add', pehideFlag , total_invdeal);
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
                        updateCountandAmount( 'remove', pehideFlag , total_invdeal );
                        updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag ,total_invcompany);
                    }
                    
                });

                //------------------------------junaid--------------------------------
                   
                    $( '.all_checkbox' ).on( 'ifChanged', function(event) {

                        if( $( event.target ).prop('checked') ) {

                           $( '#pe_checkbox_company' ).val($("#array_comma_company").val());

                           $( '.result-count .result-no span.res_total' ).text( $("#real_total_inv_deal").val() );
                           $( '.result-count .result-no span.comp_total' ).text($("#real_total_inv_company").val());
                           $( '#pe_checkbox_disbale' ).val('');
                           
                           $( '#total_inv_deal' ).val($("#real_total_inv_deal").val());
                            $( '#total_inv_company' ).val($("#real_total_inv_company").val());

                            $( '#pe_checkbox_enable' ).val('');
                            $( '#export_checkbox_enable' ).val('');
                            $( '#txthidepe' ).val('');
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
                            $( '.result-count .result-no span.comp_total' ).text('0');
                            $( '#total_inv_deal' ).val('0');
                            $( '#total_inv_amount' ).val('0');
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

                function updateCountandAmount( type, pehideFlag , total_invdeal) {
                    var totalFound = parseFloat( $( '.result-count .result-no span.res_total' ).text() );
                    if( type == 'add' ) {
                        if(pehideFlag!=1){
                        var currTotal = totalFound + 1;
                        }else{
                            var currTotal = totalFound;
                        }
                    } else {
                       if(pehideFlag!=1){
                        var currTotal = totalFound - 1;
                        }else{
                            var currTotal = totalFound;
                    }
                    }
                    
                    if(  currTotal == 0 ) {

                        $( '#expshowdeals').hide(); //junaid
                    }else{
                       $( '#expshowdeals').show(); //junaid
                    }
                
                    //------------------------------junaid--------------------------------
                 
                    if(currTotal >= total_invdeal){
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
                            /*if( lastElement ) {
                                removedcompanyData = companyData.replace( elementCompany, '' );    
                            } else {
                                removedcompanyData = companyData.replace( elementCompany+',', '' );
                            } */
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
            </script>
            <script type="text/javascript">
        
           /*$('#expshowdeals').click(function(){ 
                hrefval= 'exportinvdeals.php';
                $("#pelisting").submit();
                return false;
            });
            
            $('#expshowdealsbt').click(function(){ 
                hrefval= 'exportinvdeals.php';
                $("#pelisting").submit();
                return false;
            });*/
    
            $('#expshowdeals').click(function(){ 
                
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });
            
            $('#expshowdealsbt').click(function(){ 
                
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
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
                                hrefval= 'exportincdeals.php';
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
                 /*$(document).on('click', 'tr .details_link', function(){ 
                
                idval=$(this).attr("valueId");
                $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/incdealdetails.php?value="+idval).trigger("click");
            });*/
            </script>
                </div>
                <input type="hidden" name="period_flag" id="period_flag" value="<?php echo $period_flag; ?>" />
    </form>
    
    <form name="pelisting"  method="post" action="exportincdeals.php" id="pelisting">
        

    <input type="hidden" name="txtsearchon" value="1" >
    <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
    <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
    <input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
    <input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
    <input type="hidden" name="txthidestage" value=<?php echo $statusvalue; ?> >
    <input type="hidden" name="txthidestageid" value=<?php echo $status; ?> >
    <input type="hidden" name="txthidefirmtypeid" value=<?php echo $incfirmtype; ?> >
    <input type="hidden" name="txthidedefunct" value=<?php echo $defunctflag; ?> >
    <input type="hidden" name="txthidedefunctvalue" value=<?php echo $defunctText; ?> >
    <input type="hidden" name="txthidefollowonfund" value=<?php echo $followonFund; ?> >
    <input type="hidden" name="txthidefollowonfundvalue" value=<?php echo $followonFundText; ?> >
    <input type="hidden" name="txthideregion" value=<?php echo $regionId; ?> >
    <input type="hidden" name="txthidecity" value=<?php echo $city; ?> >
    <input type="hidden" name="txthideregiontext" value=<?php echo $regionvalue; ?> >
    <input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
    <input type="hidden" name="txthidecompany" value=<?php if($companyval){echo $companyval;}else{echo $companysearchhidden;} ?> >
    <input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
    <input type="hidden" name="txthide" value=<?php echo $searchallfieldhidden; ?> >
     <input type="hidden" name="yearafter" value=<?php echo $yearafter; ?> >
    <input type="hidden" name="yearbefore" value=<?php echo $yearbefore; ?> >
    <input type="hidden" name="txtdatefilter" value="<?php echo $datefilter; ?>" >
    <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode( ',', $pe_checkbox ); ?>">
    <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode( ',', $pe_checkbox_enable ); ?>">
    <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if($_POST['full_uncheck_flag']!=''){ echo $_POST['full_uncheck_flag']; }else{ echo ""; } ?>">
    <input type="hidden" name="tagsearch" value="<?php echo $tagsearch; ?>" >
        <input type="hidden" name="tagandor" value="<?php echo $tagandor; ?>" >
    </form>
    
      <form id="other_db_submit" method="post">
                <input type="hidden" name="searchallfield_other" id="other_searchallfield" value="<?php echo$searchallfield;?>">
                <input type="hidden" name="companyauto_other" id="companyauto_other" value="<?php echo $companyauto;?>">
                <input type="hidden" name="companysearch_other" id="companysearch_other" value="<?php echo $companysearch;?>">
                <input type="hidden" name="investorauto_sug_other" id="investorauto_sug_other" value="<?php echo $investorauto;?>">
                <input type="hidden" name="keywordsearch_other" id="keywordsearch_other" value="<?php echo $keywordsearch;?>">
                <input type="hidden" name="all_keyword_other" id="all_keyword_other" value="">
            </form> 
    
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
<script type="text/javascript" >
    $( '#month1' ).on( 'change', function() {
            $( '#period_flag' ).val(2);
        });
        $( '#year1' ).on( 'change', function() {
            $( '#period_flag' ).val(2);
        });
        $( '#month2' ).on( 'change', function() {
            $( '#period_flag' ).val(2);
        });
        <?php  /*if($_POST || $vcflagValue==6)
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
         .other_db_search{
            display: none;
            width: 100%;
            float: left;
        }
        .other_db_searchresult a{
            margin-left: 5px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .other_db_searchresult{
            background: #F2EDE1;
            padding: 10px;
            margin: 0 17px;
            font-weight: bold;
            font-size: 14px;
            /*line-height: 24px; */
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
    
    $searchStringGmail = "&industry=".implode(",",$industry)."&sector=".implode(",",$sector)."&subsector=".$subsectorString."&keyword=".$keyword."&companysearch=".$companyval."&round=".implode(",",$round)."&regionId=".implode(",",$regionId)."&city=".$city."&companyType=".$companyType."&debt_equity=".$debt_equity."&syndication=".$syndication."&investorType=".$investorType."&exitstatusValue=".implode(",",$exitstatusValue);
   
    
    //if($searchallfield!=''){ ?>
        $(document).ready(function(){
           var filed_name = "combinesearch";
            <?php if ($company_cnt==0){ ?>
                              $('.other_db_search').css('margin-top','50px');
            <?php } ?>
                
            $('.other_db_search').fadeIn();            
           $.get( "gmail_like_search.php?section=VC-Inv-Incubations&search=<?php echo $searchallfield;?><?php echo $searchStringGmail; ?>&filed_name="+filed_name, function( data ) {          
           
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
    <?php //} ?>





  $(document).ready(function(){
        // Tag Search
        var tagsearchval = $('#tagsearch').val();
        if(tagsearchval == ''){
            $('.acc_trigger.helptag').removeClass('active').next().hide();
        }
        // Tag search

 <?php if(  ($company_cnt==0) &&    ( trim($investorauto)!='' || trim($companyauto)!='' ||  trim($sectorsearch)!='' ||  trim($advisorsearchstring_legal)!='' ||  trim($advisorsearchstring_trans)!='' )){
     
     $searchList=$investorauto.$companyauto.str_replace("'","",trim($sectorsearch)).$advisorsearchstring_legal.$advisorsearchstring_trans;
     $searchList = explode(',', $searchList);
     $count=0;
     if($investorauto !=''){
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
  

    $( '.count_percent' ).click( function() {  
        
        $("#searchTagsField").val($(this).find('a').data('name'));
        $('#tagForm').submit();
    });

    $( '.lbl-action' ).click( function() {
        $( '#export_tags' ).submit();
    });
   
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

    <script>
        function paginationfun(val)
        {
            $(".pagevalue").val(val);
        }

        function validpagination()
            {
                localStorage.removeItem("pageno");
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
        width:3%;
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

left: 42%;



    }



    input[type='text']::placeholder

{   

text-align: center;      /* for Chrome, Firefox, Opera */

}
    </style>
    
    