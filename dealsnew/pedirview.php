<?php  
//print_r($_POST);
    $companyId=632270771;
    $compId=0;
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    $tagandor = $_POST['tagandor'];
    $tagradio = $_POST['tagradio'];
    $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] :0;
    if (isset($_REQUEST['search']) && $_REQUEST['search'] != '') {
        $searchallfield = $_REQUEST['search'];
    }
    //T-966
    $country_total_list_count_val = mysql_query("SELECT COUNT(DISTINCT peinvestors.countryid) as country_count from peinvestors JOIN country on country.countryid=peinvestors.countryid WHERE peinvestors.countryid NOT IN ('IN', 10, 11) and country.country != '' and country.country != '--'
    ORDER BY `country`.`country`  DESC");
    $cnty_count = mysql_fetch_array($country_total_list_count_val);
    $country_count_total = $cnty_count['country_count'];

    if($_POST['tagsearch'] != "" || $_POST['tagsearch_auto'] != "" || $tagsearch!=""){
                        $_POST['keywordsearch'] = ""; 
                        $_POST['companysearch'] = ""; 
                        $_POST['sectorsearch'] = "";
                        $_POST['advisorsearch_legal'] = ""; 
                        $_POST['advisorsearch_trans'] = ""; 
                        $_POST['invType']="";
                        $_POST['stage']="";
                        $_POST['round']="--";
                        $_POST['invrangestart']="";
                        $_POST['invrangeend']="";
                        $_POST['searchallfield']="";
                        $_POST['searchKeywordLeft']="";
                        $dirsearch = $_POST['autocomplete'] = "";
                        $_POST['citysearch']="";
                        $industry= $stageval ="";
                        $_POST['industry']="";
                        $_POST['firmtype']="";
                        $_POST['countryNIN']="";
                        $_POST['country']="";                       
    }
 

    if($vcflagValue=="")
    {
        $vcflagValue=0;
    }
    if($vcflagValue==3 || $vcflagValue==3 || $vcflagValue==4){
        $peorvcflg=3;
        $showallcompInvFlag=9;
    }
    elseif($vcflagValue==9 || $vcflagValue==10 || $vcflagValue==11 || $vcflagValue==12){
        $peorvcflg=2;
    }
    $resetfield=$_POST['resetfield'];    
    if($resetfield=="autocomplete")
    { 
     $_POST['autocomplete']="";
     $dirsearch="";
    }
    else 
    {
     $dirsearch=trim($_POST['autocomplete']);
    }
        
    if($vcflagValue !=6)
    {
        $dealvalue = (isset($_POST['showdeals']) && $_POST['showdeals']!=105 && $_POST['showdeals']!=106) ? $_POST['showdeals'] :101;
    }
    else
    {
        $dealvalue = isset($_POST['showdeals']) ? $_POST['showdeals'] :105;
    }

    if ($vcflagValue==0)
    {
            $videalPageName="PEDir";
            $defvalue=41;
    }
    else if ($vcflagValue==1)
    {
            $videalPageName="VCDir";
            $defvalue=42;
    }
    if ($vcflagValue==10 || $vcflagValue==9 || $vcflagValue==7)
    {
            $videalPageName="PEDir";
            $defvalue=41;
    }
    else if ($vcflagValue==11 || $vcflagValue==12 || $vcflagValue==8)
    {
            $videalPageName="VCDir";
            $defvalue=42;
    }
    
    include('checklogin.php');
    if($accesserror ==1 && $VCFlagValue !=1 && ($_SESSION['VCdircheckflag']==0 || $_SESSION['VCdircheckflag']=="") ){
        header("Location:".BASE_URL."dealsnew/pedirview.php?value=1");
      
         $_SESSION['VCdircheckflag'] = 1;
    }
        
    $lgDealCompId = $_SESSION['DcompanyId'];
    $usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
    $usrRgres = mysql_query($usrRgsql) or die(mysql_error());
    $usrRgs = mysql_fetch_array($usrRgres);
    
       /* if($dealvalue!=101)
        {
            $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
            $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
        }
        else
        {*/
//            if($_REQUEST['industry']!='' || $_REQUEST['stage']!='' || $_REQUEST['invType']!='' || ($_REQUEST['invrangestart']!="" && $_REQUEST['invrangestart']!="--") || ($_REQUEST['invrangeend']!="" && $_REQUEST['invrangeend']!="--") 
//                    || ($_REQUEST['month1']!="" && $_REQUEST['month1']!="--" && $_REQUEST['year1']!="--" && $_REQUEST['year1']!="" && $_REQUEST['month2']!="" && $_REQUEST['month2']!="--" && $_REQUEST['year2']!="--" && $_REQUEST['year2']!=""))
//            {
//                $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
//                $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
//            }
//            else
//            {
//                $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
//                $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
//            }
            
       // }

    
    if (isset($_REQUEST['dirsearch']) && $_REQUEST['dirsearch'] != '') {
        $dirsearch = $_REQUEST['dirsearch'];
    }
    //echo "direc : ".$dirsearch;
    if($dirsearch !='')
    {
        if($dealvalue ==101)
        {
            $dirsearchall=" and Investor like '$dirsearch%'";
        }
        else if($dealvalue ==102 || $dealvalue ==106)
        {
            $dirsearchall=" and  pec.companyname like '$dirsearch%'";
        }
        else if($dealvalue ==103 || $dealvalue ==104)
        {
            $dirsearchall=" and  cia.Cianame like '$dirsearch%'";
        }
        else if($dealvalue ==105)
        {
            $dirsearchall=" and  inc.Incubator like '$dirsearch%'";
        }
        else if($dealvalue ==111)
        {
             $dirsearch1 = mysql_real_escape_string($dirsearch);
            $dirsearchall=" and  lp.InstitutionName like '$dirsearch1%'";
        }
        $search="";
        $_REQUEST['s']="";
        $_POST['industry']="";
        $_POST['invType']="";
        $_POST['stage']="";
        $_POST['invrangestart']="";
        $_POST['invrangeend']="";
        $_POST['citysearch']="";
        
    }

    $totalCount=0;

    $resetfield=$_POST['resetfield'];
    // if($_POST['autocomplete'] != "" || $_POST['industry'] != "" || $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['round'] != "" || $_POST['invrangestart'] != "" || $_POST['invrangeend'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != "" || $_POST['country'] != "" || $_POST['city'] != "" || $_POST['countryNIN'] != ""){

    //     $_POST['searchallfield']="";
    //     $_POST['searchKeywordLeft']="";
    //     $_POST['searchTagsField']="";
    //     $searchallfield="";
       
        
        

    //     // $_POST['keywordsearch'] = "";
    //     // $_POST['companysearch'] = "";
    //     // $_POST['advisorsearch_legal'] = "";
    //     // $_POST['advisorsearch_trans'] = "";
    // }
    //exit();
    
    if( $_POST['searchallfield']!="" || $_REQUEST['search']!=''){
        if(($_POST["month1"]!="" && $_POST["year1"]!="" && $_POST["month2"]!="" && $_POST["year2"]!=""))
          { 
              if($_POST['autocomplete'] != ""|| $_POST['industry'] != ""|| $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != ""|| $_POST['round'] != "--"|| $_POST['invrangestart'] != "--" || $_POST['invrangeend'] != "--"){
                  $_POST['searchallfield']="";
                  $_POST['searchKeywordLeft']="";
                  $_POST['searchTagsField']="";
                  $searchallfield="";
                  }
          }else{
                  if($_POST['autocomplete'] != ""|| $_POST['industry'] != ""|| $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != ""|| $_POST['round'] != ""|| $_POST['invrangestart'] != "" || $_POST['invrangeend'] != ""){
              
                  
                      $_POST['searchallfield']="";
                      $_POST['searchKeywordLeft']="";
                      $_POST['searchTagsField']="";
                      $searchallfield="";
                  
                  }
          }
  }
  else{
      if($_POST['autocomplete'] != "" || $_POST['industry'] != "" || $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['round'] != "" || $_POST['invrangestart'] != "" || $_POST['invrangeend'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != "" || $_POST['country'] != "" || $_POST['city'] != "" || $_POST['countryNIN'] != ""){
  
          $_POST['searchallfield']="";
          $_POST['searchKeywordLeft']="";
          $_POST['searchTagsField']="";
          $searchallfield="";
          // $_POST['keywordsearch'] = "";
          // $_POST['companysearch'] = "";
          // $_POST['advisorsearch_legal'] = "";
          // $_POST['advisorsearch_trans'] = "";
      }
  }
  
  


    if($resetfield=="period")
    {
     $month1= 01; 
     $year1 = date('Y', strtotime(date('Y')." -1  Year"));
     $month2= date('n');
     $year2 = date('Y');
     $_POST['month1']="";
     $_POST['year1']="";
     $_POST['month2']="";
     $_POST['year2']="";
    } 
    else if(trim($_POST['keywordsearch']) !='' || trim($_POST['companysearch']) !='' || trim($_POST['advisorsearch_legal']) !='' || trim($_POST['advisorsearch_trans']) !='')
    {
        $_POST['industry']="";
        $_POST['invType']="";
        $_POST['stage']="";
        $_POST['round']="--";
        $_POST['invrangestart']="";
        $_POST['invrangeend']="";
        $_POST['searchallfield']="";
        $_POST['searchKeywordLeft']="";
        $_POST['searchTagsField']="";
        $_POST['tagsearch']="";
        $_POST['tagsearch_auto']="";
        $tagsearch="";
        $dirsearch = $_POST['autocomplete'] = "";
        $_POST['citysearch']="";
    }
    
        if($resetfield=="keywordsearch")
        { 
        $_POST['keywordsearch']="";

        $keyword="";
        }
        else 
        {
            $keyword=trim($_POST['keywordsearch']);
        }
         if($resetfield=="keywordsearchdir")
        { 
        $_POST['keywordsearchdir']="";
        
        $keyworddir="";
        }
        else 
        {
            $keyworddir=trim($_POST['keywordsearchdir']);
        }
        if($resetfield=="companysearch")
        { 
        $_POST['companysearch']="";
        $companysearch="";
        }
        else 
        {
            $companysearch=trim($_POST['companysearch']);
        }
        if($resetfield=="sectorsearch")
        { 
        $_POST['sectorsearch']="";
        $sectorsearch="";
        }
        else 
        {
            $sectorsearch=trim($_POST['sectorsearch']);
        }
        if($resetfield=="city")
        { 
            $_POST['citysearch']="";
            $city="";
        }
        else 
        {
            $city=trim($_POST['citysearch']);
            
        }
        if($resetfield=="advisorsearch_trans")
        { 
        $_POST['advisorsearch_trans']="";
        $advisorsearch_trans="";
        }
        else 
        {
            $advisorsearch_trans=trim($_POST['advisorsearch_trans']);
        }
        if($resetfield=="advisorsearch_legal")
        { 
            $_POST['advisorsearch_legal']="";
            $advisorsearch_legal="";
        }
        else 
        {
            $advisorsearch_legal=trim($_POST['advisorsearch_legal']);
        }
        if($resetfield=="industry")
        { 
            $_POST['industry']="";
            $industry="";
        }
        else 
        {
            $industry=trim($_POST['industry']);
            /*if ($industry != '--' && count($industry) > 0) {
                $searchallfield = '';
            }*/
        }

        // For Firm Type 
        if($resetfield=="firmtype")
        { 
            $_POST['firmtype']="";
            $firmtypetxt="";
        }
        else 
        {
            $firmtypetxt=$_POST['firmtype'];
        }

        $firmtypevalue=implode(",",$firmtypetxt);
        foreach($firmtypetxt as $firmid)
                    {
                            $firmsql= "select FirmType from firmtypes where FirmTypeId=$firmid";
                    //  echo "<br>**".$stagesql;
                            if ($firmtyp = mysql_query($firmsql))
                            {
                                    While($myrow=mysql_fetch_array($firmtyp, MYSQL_BOTH))
                                    {
                                            $firmvaluetext= $firmvaluetext.",".$myrow["FirmType"] ;
                                           // print_r($firmvaluetext);
                                    }
                            }
                    }
                    $firmvaluetext = substr_replace($firmvaluetext, '', 0,1);

         if($resetfield=="stage")
            { 
             $_POST['stage']="";
             $stageval="";
            }
            else 
            {
             $stageval=$_POST['stage'];
            }
           
            if($_POST['stage'] && $stageval!="")
            {
                    $boolStage=true;
            }
            else
            {
                    $stage="--";
                    $boolStage=false;
            }
            
            // Round
            if($resetfield=="round")
            { 
                $_POST['round']="";
                $round="--";
            }
            else 
            {
                $round=trim($_POST['round']);
                if($round != '--' && $_REQUEST['search']==""){
                    $searchallfield='';
                }
            }
          //  echo "dirsearch:".$dirsearch;   

            // For Country 
            if($resetfield=="country")
            { 
                $_POST['country']="";
                $countrytxt="";
                $_POST['city']="";
                $cityname ="";
                $_POST['countryNIN']="";
                $countryNINtxt ="";
                // $_POST['cityflag']='';
                // $_POST['countryNINflag']='';
                header('Location: '.$_SERVER['PHP_SELF']);
            }
            else 
            {
                $countrytxt=$_POST['country'];
            }
            

            // For City 
            if($resetfield=="city")
            { 
                $_POST['city']="";
                $cityid ="";
                header('Location: '.$_SERVER['PHP_SELF']);
            }
            else 
            {
                $cityid = $_POST['city'];
                //T-969 changes
                if(gettype($_POST['city'])!="string"){
                    $cityid = $_POST['city'];
                }else{
                    $cityid1 = $_POST['city'];
                    $cityid=explode(",",$cityid1);
                }
            }

            // For countryNIN 
            if($resetfield=="countryNIN")
            { 
                $_POST['countryNIN']="";
                $countryNINtxt ="";
                header('Location: '.$_SERVER['PHP_SELF']);
            }
            else 
            {
                 //T-969 changes
                 if(gettype($_POST['countryNIN'])!="string"){
                    $countryNINtxt = $_POST['countryNIN'];
                }else{
                    $countryNINtxt1 = $_POST['countryNIN'];
                    $countryNINtxt=explode(",",$countryNINtxt1);
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
                            // $cityname = $myrow["city_name"] ;
                            // $cityidlist = $myrow['city_id'];
                            //echo $cityname;
                        }
                        $cityname_list = implode(',', $cityname_list);
                        // print_r($cityname);
                        // exit();
                    }
                }
            }
            $countryNINval=$_POST['countryNINflag'];
            if(count($countryNINtxt) > 0){
                
                $countryNINval=$_POST['countryNINflag'];
                
                    $countryNINtxtClause = implode(",", $countryNINtxt);
                    $result_string = "'" . str_replace(",", "','", $countryNINtxtClause) . "'";
                    // $countryNINtxtClause = implode(",",$countryNINtxt);
                    $countrysql= "select countryid, country from country where countryid IN ($result_string)";
                   
                // exit();
                if ($countrytype = mysql_query($countrysql))
                {
                    
                    While($myrow = mysql_fetch_array($countrytype, MYSQL_BOTH))
                    {
                        if($countryNINval !=0 && count($countryNINtxt) != $country_count_total  ){ //T-966 changed
                        $countryNINname = $myrow["country"];
                        $countryname_list[] = "'".$myrow["country"]."'" ;
                        }else{
                            $countryNINname = "All Countries";
                        }
                        $countryNINid[] = $myrow["countryid"];
                        
                        //echo $countryNINname;
                    }
                    $countryname_list = implode(',', $countryname_list);
                    $countryid_list[] = implode(',', $countryNINid);
                    $countryid_code_v = implode(',', $countryNINid);
                    $countryid_code = "'" . str_replace(",", "','", $countryid_code_v) . "'";
                    $countryNINidList = $countryNINid;
                   //  var_dump($countryid_list);
                    // exit();
                    // print_r($countryNINidList);
                    // print_r($countryid_list);
                    // exit();
                }
            
                
            }
           
             if($countrytxt != ""){
                 if($countrytxt == "IN"){
                    $countryname = "India";
                 } else if($countrytxt == "NIN"){
                    $countryname = "Non-India";
                 }
             } 
             if ($resetfield == "tagsearch") {

    $_POST['tagsearch'] = "";
    $_POST['tagsearch_auto'] = "";
    $tagsearch = "";
    $tagandor = 0;

    } else if ($_POST['tagsearch_auto'] && $_POST['tagsearch_auto'] != '' || $_POST['tagsearch'] != '') {

        //$tagsearchauto = $_POST['tagsearch'];
        if ($_POST['tagsearch'] != '') {
            if ($_POST['tagsearch_auto'] == '') {
                $tagsearch = $_POST['tagsearch'];
            } else {
                if ($_POST['tagsearch'] != $_POST['tagsearch_auto']) {
                    $tagsearch = $_POST['tagsearch'] . "," . $_POST['tagsearch_auto'];
                } else {
                    $tagsearch = $_POST['tagsearch'];
                }
            }

        } else {
            $tagsearch = $_POST['tagsearch_auto'];
    }
    

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



            $endRangeValueDisplay =$endRangeValue;
            $whereind="";
            $whereinvType="";
            $wherestage="";
            $whereRound="";
            $wheredates="";
            $whererange="";
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
                    }else if($_POST['popup_select'] == '' && $_POST['popup_keyword'] !=''){
                        $searchallfield=trim($_POST['popup_keyword']);
                    }
                    if($searchallfield != "")
                    {
                        $_POST['keywordsearch'] = ""; 
                        $_POST['companysearch'] = ""; 
                        $_POST['sectorsearch'] = "";
                        $_POST['advisorsearch_legal'] = ""; 
                        $_POST['advisorsearch_trans'] = ""; 
                        $_POST['tagsearch'] = "";
                        $_POST['tagsearch_auto'] = "";
                    }
               }
            
               if($resetfield=="followonVCFund")
                { 
                 $_POST['followonVCFund']="";
                 $followonVC="--";
                }
                else 
                {
                    $followonVC=trim($_POST['followonVCFund']);
                    if($followonVC!='--' && $followonVC!=''){
                        $searchallfield='';
                    }
                }
                if($followonVC=="--"){
                    $followonVCFund="--";
                }
                elseif($followonVC==1){
                    $followonVCFund=1;
                }   
                elseif($followonVC==2)
                {
                    $followonVCFund=3;
                }
                if($followonVCFund =="--")
                {
                    $followonVCFundText=="";
                }
                elseif($followonVCFund=="1")
                {
                    $followonVCFundText="Follow on Funding";
                }
                elseif($followonVCFund=="3")
                {
                    $followonVCFundText="No Funding";
                }
                
                if($resetfield=="exitedstatus")
                { 
                    $_POST['exitedstatus']="";
                    $exitvalue="--";
                }
                else 
                {
                    $exitvalue=trim($_POST['exitedstatus']);
                    if($exitvalue!='--' && $exitvalue!=''){
                        $searchallfield='';
                    }
                }
                if($exitvalue=="--")
                    $exited="--";
                elseif($exitvalue==1)
                    $exited=1;
                elseif($exitvalue==2)
                    $exited=3;
                
                if($exited =="--")
                {
                    $exitedText="";
                }
                elseif($exited=="1")
                {
                    $exitedText="Exited";
                }
                elseif($exited=="3")
                {
                    $exitedText="Not Exited";

                }
                
                if($resetfield=="txtregion")
                { 
                 $_POST['txtregion']="";
                }
                else 
                {
                 $txtregion=$_POST['txtregion'];
                    if($txtregion!='--' && count($txtregion) > 0){
                        $searchallfield='';
                    }
                }
                
                if($txtregion =="--")
                {
                    $regionText="";
                }
                else
                {
                   // $regionText="Region";
                    if(count($txtregion) >0)
                    {
                        $region_Sql = $regionvalue = '';
                        foreach($txtregion as $regionIds)
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
                        $regionText = trim($regionvalue,', ');
                        $region_hide = implode($txtregion, ',');
                    }
                }
                
                $searchString="Undisclosed";
                $searchString=strtolower($searchString);

                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);

                $searchString2="Others";
                $searchString2=strtolower($searchString2);
 
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
                // Round Value
                if($round!="--" || $round != null)
                {
                    $roundSql="SELECT * FROM `peinvestments` where `round` like '".$round."%'  group by `round`";
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
                                            $stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
                                    }
                            }
                    }
                    $stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
        }
        else
                {
            $stagevaluetext="";
            
                        if($investorType !="")
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
                }
        //echo "<br>*************".$stagevaluetext;
        if($companyType=="L")
                $companyTypeDisplay="Listed";
        elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
            elseif($companyType=="--")
                        $companyTypeDisplay="";

                if($investorType !="")
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
                
            if($countryNINtxt != "" || $cityname != "" || $countryname != "" || $_POST['searchallfield']!='' || $_POST['keywordsearch']!='' || $_POST['advisorsearch_trans']!='' || $_POST['companysearch']!='' || $_POST['industry']!='' || $_POST['stage']!='' || $_POST['invType']!='' || ($_POST['invrangestart']!="" && $_POST['invrangestart']!="--") || ($_POST['invrangeend']!="" && $_POST['invrangeend']!="--") 
                    || ($_POST['month1']!="" && $_POST['month1']!="--" && $_POST['year1']!="--" && $_POST['year1']!="" && $_POST['month2']!="" && $_POST['month2']!="--" && $_POST['year2']!="--" && $_POST['year2']!=""))
            {
                //echo "check";
                $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
                $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
            }
            else
            {
                $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
                $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
                // $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
                // $_REQUEST['s']=isset($_REQUEST['s']) ? $_REQUEST['s'] : 'a';
            }
                if($search !='')
                {
                    if($dealvalue ==101)
                    {
                         $search=" and Investor like '$search%'"; 
                    }
                    else if($dealvalue ==102 || $dealvalue ==106)
                    {
                        $search=" and  pec.companyname like '$search%'";
                    }
                    else if($dealvalue ==103 || $dealvalue ==104)
                    {

                        $search=" and  cia.Cianame like '$search%'";
                    }
                     else if($dealvalue ==105)
                    {
                        $search=" and  inc.Incubator like '$search%'";
                    }
                    else if($dealvalue ==111)
                    {
                        $search=" and  lp.InstitutionName like '$search%'";
                    }
                }
                if($vcflagValue==0)
                {
                        $addVCFlagqry="";
                        $pagetitle="PE Investors";
                }
                elseif($vcflagValue==1)
                {
                        //$addVCFlagqry="";
                        $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                        $pagetitle="VC Investors";
                }
                else if($vcflagValue==2)
                {
                       $addVCFlagqry="";
            $pagetitle="Angel Investments - Investors";
                }
                elseif($vcflagValue==3)
                {
                        $addVCFlagqry = "";
            $dbtype="SV";
                        $showallcompInvFlag=8;
                        $peorvcflg=3;
            $pagetitle="Social Venture Investments - Investors";
                }
                else if($vcflagValue==4)
                {
                        $addVCFlagqry = "";
            $dbtype="CT";
                        $showallcompInvFlag=9;
                        $peorvcflg=3;
            $pagetitle="CleanTech Investments - Investors";
                }
                elseif($vcflagValue==5)
                {
                        $addVCFlagqry = "";
            $dbtype="IF";
                        $showallcompInvFlag=10;
                        $peorvcflg=3;
            $pagetitle="Infrastructure Investments - Investors";
                }
                elseif($vcflagValue==7)
                {
                        $addVCFlagqry="";
                        $showallcompInvFlag=3;
                        $peorvcflg=2;
            $pagetitle="PE Backed IPOs - Investors";
                }
                else if($vcflagValue==8)
                {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $showallcompInvFlag=4;
                        $peorvcflg=2;
                        $pagetitle="VC Backed IPOs - Investors";
                }
                else if($vcflagValue==9)
                {
                        $addVCFlagqry = "";
                        $showallcompInvFlag=11;
                        $peorvcflg=4;
                        $pagetitle="PMS - Investors";
                }
                else if($vcflagValue==10)
                {
                        $addVCFlagqry="";
                        $showallcompInvFlag=5;
                        $peorvcflg=4;
                        $pagetitle="PE Exits M&A - Investors";
                }
                elseif($vcflagValue==11)
                {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $showallcompInvFlag=6;
                        $peorvcflg=4;
            $pagetitle="VC Exits M&A - Investors";
                }
                elseif($vcflagValue==12)
                {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $showallcompInvFlag=11;
                        $peorvcflg=4;
            $pagetitle="VCPMS - Investors";
                }
                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }

                
                
                if($_POST['month1'] == "" && $_POST['year1'] == "" && $_POST['month2'] == "" && $_POST['year2'] == "") {
                    $_POST['month1'] = date('m');
                    $_POST['year1'] = date('Y') - 3;
                    $_POST['month2'] = date('m');
                    $_POST['year2'] = date('Y');
                }
                
                if($dirsearchall != ""){
                    $_POST['month1'] = 01;
                    $_POST['year1'] = 1998;
                    $_POST['month2'] = date('n');
                    $_POST['year2'] = date('Y');
                }

                $month1=$_POST['month1'];
                $year1 = $_POST['year1'];
                $month2=$_POST['month2'];
                $year2 = $_POST['year2'];


                $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
                $splityear1=(substr($year1,2));
                $splityear2=(substr($year2,2));
                $sdatevalueCheck1 = returnMonthname($month1) ." ".$splityear1;
                $edatevalueCheck2 = returnMonthname($month2) ."  ".$splityear2;
               
               /* if($sdatevalueDisplay1 == $sdatevalueCheck1)
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
                   
                if($_SESSION['PE_industries']!=''){

                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                //T-966 added
                if($countryNINtxt[0]!="" && $countryNINtxt != "---" && $countryNINtxt != "" && $countrytxt !="")
                {
                    $country_value_check = 1;
                }else{
                    $country_value_check = 0;
                }    
                if($vcflagValue==0 || $vcflagValue==1)
                {if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates1 = " and dates between '" . $dt1. "' and '" . $dt2 . "' ";
                           }
                    if($dealvalue==101)
                    {
                         if($keyword!="")
                         {
                            $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*,GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                            from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i
                            where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                            pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and
                            pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and Investor like '%$keyword%' $comp_industry_id_where group by inv.Investor  order by inv.Investor ";

                            $totalallsql=$exportsql=$showallsql;
                             //echo "<br> Investor search 0 or 1- ".$showallsql;
                         }
                         elseif($companysearch!="")
                         {
                                 $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*, GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry , GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                                 from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i
                                 where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                 pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and 
                                 pe.Deleted=0 " .$addVCFlagqry. $wheredates1." and pec.companyname like '%$companysearch%' $comp_industry_id_where group by inv.Investor  order by inv.Investor ";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> company search-0 or 1 ".$showallsql;
                         }
                         elseif($sectorsearch!="")
                         {
                                 $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*,GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                                 from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i
                                 where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                 pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and peinv.InvestorId!=9 and
                                 pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and pec.sector_business like '%$sectorsearch%' $comp_industry_id_where order by inv.Investor ";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> sector search 0 or 1- ".$showallsql;
                         }
                         elseif($advisorsearch_legal!="")
                         {
                                 $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                     pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                     pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                     " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' $comp_industry_id_where order by inv.Investor )
                                     UNION(select distinct peinv.InvestorId,inv.Investor,inv.* 
                                     from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                     peinvestments_advisorcompanies AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                     pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 " .$addVCFlagqry.$wheredates1. "
                                     and cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' $comp_industry_id_where order by inv.Investor )";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br>advisor_legal search 0 or 1- ".$showallsql;
                         }
                         elseif($advisorsearch_trans!="")
                         {
                                 $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                     pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                     pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                     " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' $comp_industry_id_where order by inv.Investor )
                                     UNION(select distinct peinv.InvestorId,inv.Investor,inv.* 
                                     from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                     peinvestments_advisorcompanies AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                     pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 " .$addVCFlagqry.$wheredates1. "
                                     and cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' $comp_industry_id_where order by inv.Investor )";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> $advisor_trans search 0 or 1- ".$showallsql;
                         }elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }

                            $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*,GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                                 from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,industry as i
                                 where $wheredates peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                 pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry  and i.industryid=pec.industry and s.StageId=pe.StageId and
                                 pe.Deleted=0 " .$addVCFlagqry.$wheredates1." and ( $tagsval ) $search $comp_industry_id_where group by inv.Investor order by inv.Investor ";

                                 $totalallsql=$exportsql=$showallsql;                                
                         }elseif($searchallfield!="")
                        {

                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates = " dates between '" . $dt1. "' and '" . $dt2 . "' and";
                           }
                             
                             $findTag = strpos($searchallfield,'tag:');
                             $findTags = "$findTag";
                             if($findTags == ''){
                                 /*$tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'"; */
                                $searchExplode = explode( ' ', $searchallfield );
                                foreach( $searchExplode as $searchFieldExp ) {
                                    $cityLike .= "inv.City REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $countryLike .= "c.country REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $ZipLike .= "inv.Zip REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $investorLike .= "inv.investor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $websiteLike .= "inv.website REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $AdditionalInforLike .= "inv.AdditionalInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $DescriptionLike .= "inv.Description REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $Address1Like .= "inv.Address1 REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $Address2Like .= "inv.Address2 REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $TelephoneLike .= "inv.Telephone REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $EmailLike .= "inv.Email REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $yearfoundedLike .= "inv.yearfounded REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $linkedInLike .= "inv.linkedIn REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $FirmTypeLike .= "inv.FirmType REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $OtherLocationLike .= "inv.OtherLocation REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $Assets_mgmtLike .= "inv.Assets_mgmt REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $LimitedPartnersLike .= "inv.LimitedPartners REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $NoFundsLike .= "inv.NoFunds REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $MinInvestmentLike .= "inv.MinInvestment REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,' OR ";
                                }
                                $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                                $cityLike = '('.trim($cityLike,'AND ').')';
                                $countryLike = '('.trim($countryLike,'AND ').')';
                                $ZipLike = '('.trim($ZipLike,'AND ').')';
                                $investorLike = '('.trim($investorLike,'AND ').')';
                                $websiteLike = '('.trim($websiteLike,'AND ').')';
                                $AdditionalInforLike = '('.trim($AdditionalInforLike,'AND ').')';
                                $DescriptionLike = '('.trim($DescriptionLike,'AND ').')';
                                $Address1Like = '('.trim($Address1Like,'AND ').')';
                                $Address2Like = '('.trim($Address2Like,'AND ').')';
                                $TelephoneLike = '('.trim($TelephoneLike,'AND ').')';
                                $EmailLike = '('.trim($EmailLike,'AND ').')';
                                $yearfoundedLike = '('.trim($yearfoundedLike,'AND ').')';
                                $linkedInLike = '('.trim($linkedInLike,'AND ').')';
                                $FirmTypeLike = '('.trim($FirmTypeLike,'AND ').')';
                                $OtherLocationLike = '('.trim($OtherLocationLike,'AND ').')';
                                $Assets_mgmtLike = '('.trim($Assets_mgmtLike,'AND ').')';
                                $LimitedPartnersLike = '('.trim($LimitedPartnersLike,'AND ').')';
                                $NoFundsLike = '('.trim($NoFundsLike,'AND ').')';
                                $MinInvestmentLike = '('.trim($MinInvestmentLike,'AND ').')';
                                $tagsLike = '('.trim($tagsLike,'OR ').')';
                                $tagsval = $cityLike . ' OR ' . $countryLike . ' OR ' . $ZipLike . ' OR ' . $investorLike . ' OR ' . $websiteLike . ' OR ' . $AdditionalInforLike . ' OR ' . $DescriptionLike . ' OR ' . $Address1Like . ' OR ' . $Address2Like . ' OR ' . $TelephoneLike . ' OR ' . $EmailLike . ' OR ' . $yearfoundedLike . ' OR ' . $linkedInLike . ' OR ' . $FirmTypeLike . ' OR ' . $OtherLocationLike . ' OR ' . $Assets_mgmtLike . ' OR ' . $LimitedPartnersLike . ' OR ' . $NoFundsLike . ' OR ' . $MinInvestmentLike . ' OR ' . $tagsLike;                                   
                             }else{
                                 $tags = '';
                                 $ex_tags = explode(',',$searchallfield);
                                 if(count($ex_tags) > 0){
                                     for($l=0;$l<count($ex_tags);$l++){
                                         if($ex_tags[$l] !=''){
                                             $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                             //$tags .= "pec.tags like '%:$value%' or ";
                                             $tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP 
                                         }
                                     }
                                 }
                                 $tagsval = trim($tags,' or ');
                             }
                                 $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                          
                                 from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,industry as i
                                 where $wheredates peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                 pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and
                                 pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) $search $comp_industry_id_where order by inv.Investor ";

                                 $totalallsql=$exportsql=$showallsql;                                
                         }
                         else
                         {
                            $showallsql = "select distinct peinv.InvestorId,inv.Investor,inv.* , 
                            GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                            from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv ,industry AS i
                             where ";

                             //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0)
                                $whereind = " pec.industry=" .$industry ;

                            if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                            
                                if (count($countryNINtxt) > 0 && $country_value_check == 1) //T-966 changes
                                {
                                    if($countryNINtxt[0] == 'All'){//T-966 changes
                                        $wherecountryNIN = " inv.countryid != 'IN'" ;
                                    } else {
                                        $wherecountryNIN = " inv.countryid IN (".$countryid_code.")" ;
                                    }
                                }
                            
                            
                            if (count($cityname_list) && $cityid[0] != "--")
                                $wherecitytxt = " inv.City IN (".$cityname_list.")";
                                // $wherecitytxt = " inv.City IN ".($cityname_list);

                            if ($investorType!= "")
                                $whereInvType = " pe.InvestorType = '".$investorType."'";

                            if ($firmtypetxt!= "" && $firmtypetxt != "--")
                                $wherefirmtypetxt = " inv.FirmTypeId IN (".$firmtypevalue.")";

                            if($city != "")
                            {
                               $whereCity=" pec.city LIKE '".$city."'";
                            }
                             
                            if ($boolStage==true)
                            {
                                $stagevalue="";
                                $stageidvalue="";
                                foreach($stageval as $stage)
                                {
                                        //echo "<br>****----" .$stage;
                                        $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                        $stageidvalue=$stageidvalue.",".$stage;
                                }

                                $wherestage = $stagevalue ;
                                $qryDealTypeTitle="Stage  - ";
                                $strlength=strlen($wherestage);
                                $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                             //echo "<br>---" .$stringto;

                            }
                              //
                             if($round != "--" && $round !="")
                             {
                                 $whereRound=" pe.round LIKE '".$round."'";
                             }
                             //
                            if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                            {
                                $startRangeValue=$startRangeValue;
                                $endRangeValue=$endRangeValue-0.01;
                                $qryRangeTitle="Deal Range (M$) - ";
                                if($startRangeValue < $endRangeValue)
                                {
                                        $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                }
                                elseif($startRangeValue = $endRangeValue)
                                {
                                        $whererange = " pe.amount >= ".$startRangeValue ."";
                                }
                            }

                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                            }
                             if ($whereind != "")
                             {
                                     $showallsql=$showallsql . $whereind ." and ";

                                     $bool=true;
                             }
                             else
                             {
                                     $bool=false;
                             }

                             if (($wherestage != ""))
                             {
                                     $showallsql=$showallsql. $wherestage . " and " ;
                                     $bool=true;
                             }

                             if ($wherecountry != "")
                             {
                                     $showallsql=$showallsql . $wherecountry ." and ";
                                     $bool=true;
                             }
                             if ($wherecountryNIN != "")
                             {
                                     $showallsql=$showallsql . $wherecountryNIN ." and ";
                                     $bool=true;
                             }
                             if ($wherecitytxt != "")
                             {
                                     $showallsql=$showallsql . $wherecitytxt ." and ";
                                     $bool=true;
                             }


                             if($whereRound !="")
                                     {
                                         $showallsql=$showallsql.$whereRound." and ";
                                     }
                             if (($whereInvType != "") )
                             {
                                     $showallsql=$showallsql.$whereInvType . " and ";
                                     $bool=true;
                             }
                             if (($wherefirmtypetxt != "") )
                             {
                                     $showallsql=$showallsql.$wherefirmtypetxt . " and ";
                                     $bool=true;
                             }
                             if (($whererange != "") )
                             {
                                     $showallsql=$showallsql.$whererange . " and ";
                                     $bool=true;
                             }
                             if(($wheredates !== "") )
                             {
                                     $showallsql = $showallsql . $wheredates ." and ";
                                     $bool=true;
                             }

                             if($whereCity !="")
                             {
                                 $showallsql=$showallsql.$whereCity." and ";
                             }

                             $totalallsql = $exportsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                             pe.StageId=s.StageId  AND i.industryid = pec.industry and pec.industry!=15 and
                             pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " ".$dirsearchall.$comp_industry_id_where." GROUP BY peinv.InvestorId order by inv.Investor ";

                             $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                             pe.StageId=s.StageId  AND i.industryid = pec.industry and pec.industry!=15 and
                             pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " " .$search." ".$dirsearchall.$comp_industry_id_where." GROUP BY peinv.InvestorId order by inv.Investor ";
                             
                            //  echo $showallsql;exit(); //testing
                         }

                    }
                    elseif($dealvalue==111)
                    {
                         if($keyworddir!="")
                         {
                            /*$showallsql="select distinct lp.*
                            from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i,limited_partners as lp
                            where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                            pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and
                            pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1" .$addVCFlagqry. " and inv.Investor like '%$keyword%' $comp_industry_id_where  GROUP BY lp.LPId order by lp.InstitutionName ";*/
                            $showallsql="select distinct lp.*
                            from peinvestors as inv,limited_partners as lp
                            where inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, trim(REPLACE( inv.LimitedPartners,', ',','))) and lp.Deleted!=1" .$addVCFlagqry. " and inv.Investor like '%$keyworddir%'  GROUP BY lp.LPId order by lp.InstitutionName ";

                            $totalallsql=$exportsql=$showallsql;
                             //echo "<br> Investor search 0 or 1- ".$showallsql;
                         }elseif($searchallfield!="")
                         {
 
                         //    if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                         //         $dt1 = $year1."-".$month1."-01";
                         //         $dt2 = $year2."-".$month2."-01";
                         //         $wheredates = " dates between '" . $dt1. "' and '" . $dt2 . "' and";
                         //    }
                              
                              $findTag = strpos($searchallfield,'tag:');
                              $findTags = "$findTag";
                             
                                  /*$tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'"; */
                                 $searchExplode = explode( ' ', $searchallfield );
                                 foreach( $searchExplode as $searchFieldExp ) {
                                     $LimitedPartnersLike .= "lp.InstitutionName REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    // $cityLike .= "inv.City REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    // $countryLike .= "c.country REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                  //   $ZipLike .= "inv.Zip REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                //     $investorLike .= "inv.investor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $websiteLike .= "inv.website REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $AdditionalInforLike .= "inv.AdditionalInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $DescriptionLike .= "inv.Description REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $Address1Like .= "inv.Address1 REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $Address2Like .= "inv.Address2 REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $TelephoneLike .= "inv.Telephone REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $EmailLike .= "inv.Email REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $yearfoundedLike .= "inv.yearfounded REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $linkedInLike .= "inv.linkedIn REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $FirmTypeLike .= "inv.FirmType REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $OtherLocationLike .= "inv.OtherLocation REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $Assets_mgmtLike .= "inv.Assets_mgmt REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $NoFundsLike .= "inv.NoFunds REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $MinInvestmentLike .= "inv.MinInvestment REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,' OR ";
                                 }
                                 $LimitedPartnersLike = '('.trim($LimitedPartnersLike,'AND ').')';
                              //   $investorLike = '('.trim($investorLike,'AND ').')';
                                // $cityLike = '('.trim($cityLike,'AND ').')';
                                // $countryLike = '('.trim($countryLike,'AND ').')';
                                // $ZipLike = '('.trim($ZipLike,'AND ').')';
                                //   $websiteLike = '('.trim($websiteLike,'AND ').')';
                                //  $AdditionalInforLike = '('.trim($AdditionalInforLike,'AND ').')';
                                //  $DescriptionLike = '('.trim($DescriptionLike,'AND ').')';
                                //  $Address1Like = '('.trim($Address1Like,'AND ').')';
                                //  $Address2Like = '('.trim($Address2Like,'AND ').')';
                                //  $TelephoneLike = '('.trim($TelephoneLike,'AND ').')';
                                //  $EmailLike = '('.trim($EmailLike,'AND ').')';
                                //  $yearfoundedLike = '('.trim($yearfoundedLike,'AND ').')';
                                //  $linkedInLike = '('.trim($linkedInLike,'AND ').')';
                                //  $FirmTypeLike = '('.trim($FirmTypeLike,'AND ').')';
                                //  $OtherLocationLike = '('.trim($OtherLocationLike,'AND ').')';
                                //  $Assets_mgmtLike = '('.trim($Assets_mgmtLike,'AND ').')';
                                //  $NoFundsLike = '('.trim($NoFundsLike,'AND ').')';
                                //  $MinInvestmentLike = '('.trim($MinInvestmentLike,'AND ').')';
                                //  $tagsLike = '('.trim($tagsLike,'OR ').')';
                                //  $tagsval =$LimitedPartnersLike . ' OR ' . $cityLike . ' OR ' . $countryLike . ' OR ' . $investorLike . ' OR ' . $websiteLike . ' OR ' . $AdditionalInforLike . ' OR ' . $DescriptionLike . ' OR ' . $Address1Like . ' OR ' . $Address2Like . ' OR ' . $TelephoneLike . ' OR ' . $EmailLike . ' OR ' . $yearfoundedLike . ' OR ' . $linkedInLike . ' OR ' . $FirmTypeLike . ' OR ' . $OtherLocationLike . ' OR ' . $Assets_mgmtLike . ' OR ' .  $NoFundsLike . ' OR ' . $MinInvestmentLike . ' OR ' . $tagsLike;                                   
                                $tagsval =$LimitedPartnersLike ;                                   
                             
                                  $showallsql="select distinct lp.*
                                  from limited_partners as lp
                                  where  lp.Deleted!=1" .$addVCFlagqry. " and ( $tagsval ) $search GROUP BY lp.LPId order by lp.InstitutionName ";
 
                                  $totalallsql=$exportsql=$showallsql;                                
                          }
                         else
                         {
                         	if($vcflagValue==1)
                         	{
                         		$joinvctable=" ,peinvestments as pe,peinvestments_investors as peinv";
                         		$vccondition=" and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.amount<=20  ";
                         	}

                            // $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                            //  where    inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                            //  ";
                             /*$showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                             where    inv.LimitedPartners !='' and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                             ";*/

                             $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv" .$joinvctable."
                             where    inv.LimitedPartners !='' and lp.Deleted!=1  " .$search.$dirsearchall.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                             ";
                             $totalallsql=$exportsql=$showallsql;  

                            
                         }
                         


                    }
                    elseif($dealvalue==102)
                    {
                        $companynamefilter="and pec.companyname NOT LIKE 'Undisclosed%' and pec.companyname NOT LIKE 'Unknown%' and pec.companyname NOT LIKE 'Others%'";
                        if($companysearch!="")
                         {
                                 $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                       FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                       WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                       AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                       AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. $wheredates1." and pec.companyname LIKE '%$companysearch%' $comp_industry_id_where
                                       ORDER BY pec.companyname";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> Investor search 0 or 1- ".$showallsql;
                         }
                         else if($keyword!="")
                         {

                             $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                       FROM peinvestments_investors as peinv,pecompanies AS pec, peinvestments AS pe,peinvestors as inv, industry AS i, region AS r , stage AS s
                                       WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                       AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                       AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. " and Investor like '%$keyword%' $comp_industry_id_where
                                       ORDER BY pec.companyname";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> Investor search 0 or 1- ".$showallsql;
                         }
                         elseif($sectorsearch!="")
                         {
                             $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                       FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                       WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                       AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                       AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. " and pec.sector_business like '%$sectorsearch%' $comp_industry_id_where
                                       ORDER BY pec.companyname";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> sector search 0 or 1- ".$showallsql;
                         }
                         elseif($advisorsearch_legal!="")
                         {

                             $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                         FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                         peinvestments_advisorinvestors AS adac, industry AS i, region AS r , stage AS s
                                         WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                         AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. " AND adac.CIAId = cia.CIAID AND 
                                         cia.cianame LIKE '%$advisorsearch_legal%' $comp_industry_id_where and AdvisorType='L' AND adac.PEId = pe.PEId)
                                         UNION (SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                         FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                         peinvestments_advisorcompanies AS adac, industry AS i, region AS r , stage AS s
                                         WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                         AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. $wheredates1." AND adac.CIAId = cia.CIAID AND 
                                         cia.cianame LIKE '%$advisorsearch_legal%' $comp_industry_id_where and AdvisorType='L' AND adac.PEId = pe.PEId) 
                                         ORDER BY companyname";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br>advisor_legal search 0 or 1- 102l".$showallsql;
                         }
                         elseif($advisorsearch_trans!="")
                         {
                                 $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                         FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                         peinvestments_advisorinvestors AS adac, industry AS i, region AS r , stage AS s
                                         WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                         AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. " AND adac.CIAId = cia.CIAID AND 
                                         cia.cianame LIKE '%$advisorsearch_trans%' $comp_industry_id_where and AdvisorType='T' AND adac.PEId = pe.PEId)
                                         UNION (SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                         FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                         peinvestments_advisorcompanies AS adac, industry AS i, region AS r , stage AS s
                                         WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                         AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. " AND adac.CIAId = cia.CIAID AND 
                                         cia.cianame LIKE '%$advisorsearch_trans%' $comp_industry_id_where and AdvisorType='T' AND adac.PEId = pe.PEId) 
                                         ORDER BY companyname";

                                 $totalallsql=$exportsql=$showallsql;
                            //echo "<br> $advisor_trans search 0 or 1-102t ".$showallsql;
                         }
                         elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }

                                     $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                       FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                       WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                       AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                       AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1." and
                                          ( $tagsval )  $search $comp_industry_id_where
                                       ORDER BY pec.companyname";

                                 $totalallsql=$exportsql=$showallsql;

                        }
                        elseif($searchallfield!="")
                         {
                            $findTag = strpos($searchallfield,'tag:');
                             $findTags = "$findTag";
                             if($findTags == ''){
                                 $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                         OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                             }else{
                                 $tags = '';
                                 $ex_tags = explode(',',$searchallfield);
                                 if(count($ex_tags) > 0){
                                     for($l=0;$l<count($ex_tags);$l++){
                                         if($ex_tags[$l] !=''){
                                             $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                             $tags .= "pec.tags like '%:$value%' or ";
                                         }
                                     }
                                 }
                                 $tagsval = trim($tags,' or ');
                             }
                                 $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                       FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                       WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                       AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                       AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1." and
                                          ( $tagsval )  $search $comp_industry_id_where
                                       ORDER BY pec.companyname";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> Investor search 0 or 1- ".$showallsql;
                         }
                         else
                         {
                         $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                       FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s , peinvestments_investors AS peinv , peinvestors AS inv
                                       WHERE ";

                             if ($industry > 0)
                                     $whereind = " pec.industry=" .$industry ;     
                                 
                            if (count($cityname_list) > 0 && $cityid[0] != "--")
                                $wherecitytxt = " inv.City IN (".$cityname_list.")";
                        
                                      if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                      $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                                  
                                  

                                if (count($countryNINtxt) > 0 && $country_value_check == 1) //T-966 changes
                                {
                                    if($countryNINtxt[0] == 'All'){//T-966 changes
                                        $wherecountryNIN = " inv.countryid != 'IN'" ;
                                    } else {
                                        $wherecountryNIN = " inv.countryid IN (".$countryid_code.")" ;
                                    }
                                }

                             if ($investorType!= "")
                                     $whereInvType = " pe.InvestorType = '".$investorType."'";

                             if($city != "")
                             {
                                 $whereCity=" pec.city LIKE '".$city."'";
                             }

                             if ($boolStage==true)
                             {
                                     $stagevalue="";
                                     $stageidvalue="";
                                     foreach($stageval as $stage)
                                     {
                                             //echo "<br>****----" .$stage;
                                             $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                             $stageidvalue=$stageidvalue.",".$stage;
                                     }

                                     $wherestage = $stagevalue ;
                                     $qryDealTypeTitle="Stage  - ";
                                     $strlength=strlen($wherestage);
                                     $strlength=$strlength-3;
                             //echo "<Br>----------------" .$wherestage;
                             $wherestage= substr ($wherestage , 0,$strlength);
                             $wherestage ="(".$wherestage.")";
                             //echo "<br>---" .$stringto;

                             }
                              //
                                         if($round != "--" && $round !="")
                                         {
                                             $whereRound=" pe.round LIKE '".$round."'";
                                         }
                                     //

                            if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                            {
                                    $startRangeValue=$startRangeValue;
                                    $endRangeValue=$endRangeValue-0.01;
                                    $qryRangeTitle="Deal Range (M$) - ";
                                    if($startRangeValue < $endRangeValue)
                                    {
                                            $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                    }
                                    elseif($startRangeValue = $endRangeValue)
                                    {
                                            $whererange = " pe.amount >= ".$startRangeValue ."";
                                    }
                            }

                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                            }
                             if ($whereind != "")
                             {
                                     $showallsql=$showallsql . $whereind ." and ";

                                     $bool=true;
                             }
                             else
                             {
                                     $bool=false;
                             }

                             if (($wherestage != ""))
                             {
                                     $showallsql=$showallsql. $wherestage . " and " ;
                                     $bool=true;
                             }
                             if($whereRound !="")
                                     {
                                         $showallsql=$showallsql.$whereRound." and ";
                                     }
                             if (($whereInvType != "") )
                             {
                                     $showallsql=$showallsql.$whereInvType . " and ";
                                     $bool=true;
                             }
                             if (($whererange != "") )
                             {
                                     $showallsql=$showallsql.$whererange . " and ";
                                     $bool=true;
                             }
                             if(($wheredates !== "") )
                             {
                                     $showallsql = $showallsql . $wheredates ." and ";
                                     $bool=true;
                             }
                             if($whereCity !="")
                             {
                                 $showallsql=$showallsql.$whereCity." and ";
                             }
                             if ($wherecountry != "")
                             {
                                     $showallsql=$showallsql . $wherecountry ." and ";
                                     $bool=true;
                             }
                             if ($wherecountryNIN != "")
                             {
                                     $showallsql=$showallsql . $wherecountryNIN ." and ";
                                     $bool=true;
                             }
                             if ($wherecitytxt != "")
                             {
                                     $showallsql=$showallsql . $wherecitytxt ." and ";
                                     $bool=true;
                             }
                             $totalallsql =$exportsql= $showallsql. "pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                       and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId
                                       AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                       AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. " ".$dirsearchall.$comp_industry_id_where."
                                       ORDER BY pec.companyname";

                             $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                       and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId
                                       AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                       AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. " " .$search." ".$dirsearchall.$comp_industry_id_where."
                                       ORDER BY pec.companyname";
                         }
                    }
                    else if($dealvalue==103 || $dealvalue==104)
                    {
                        if($_SESSION['PE_industries']!=''){

                            $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
                        }
                        
                        if($advisorsearch_trans!="")
                        {
                            $showallsql="(
                             SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                             peinvestments_advisorinvestors AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where)
                             UNION (
                             SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                             peinvestments_advisorcompanies AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where ) order by Cianame";

                            $totalallsql=$exportsql=$showallsql;

                            //echo "0 or 1".$showallsql;
                        }
                         else if($advisorsearch_legal!="")
                        {
                            $showallsql="(
                             SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                             peinvestments_advisorinvestors AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where)
                             UNION (
                             SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                             peinvestments_advisorcompanies AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where) order by Cianame";

                            $totalallsql=$exportsql=$showallsql;

                            //echo "0 or 1".$showallsql;
                        }
                        elseif($companysearch!="")
                        {
                            $showallsql="(
                             SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                             peinvestments_advisorinvestors AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where)
                             UNION (
                             SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                             peinvestments_advisorcompanies AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where) order by Cianame";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "0 or 1".$showallsql;
                         }
                         else if($keyword!="")
                        {
                              $showallsql="(
                             SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments_investors as peinv, peinvestments AS pe, pecompanies AS c,peinvestors as inv, advisor_cias AS cia,
                             peinvestments_advisorinvestors AS adac, stage as s
                             WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.$wheredates1." 
                             AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where)
                             UNION (
                             SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments_investors as peinv,peinvestments AS pe, pecompanies AS c,peinvestors as inv,  advisor_cias AS cia,
                             peinvestments_advisorcompanies AS adac, stage as s
                             WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where) order by Cianame";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "0 or 1".$showallsql;
                         }
                         elseif($sectorsearch!="")
                        {
                              $showallsql="(
                                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                                peinvestments_advisorinvestors AS adac, stage as s
                                WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.$wheredates1.
                                " AND c.PECompanyId = pe.PECompanyId
                                AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
                                AND adac.PEId = pe.PEId $comp_industry_id_where)
                                UNION (
                                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                                peinvestments_advisorcompanies AS adac, stage as s
                                WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.$wheredates1.
                                " AND c.PECompanyId = pe.PECompanyId
                                AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
                                AND adac.PEId = pe.PEId $comp_industry_id_where) order by Cianame";

                                $totalallsql=$exportsql=$showallsql;
                            //echo "0 or 1".$showallsql;
                         }
                          elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(c.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(c.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                     $showallsql="(
                             SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                             peinvestments_advisorinvestors AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID and 
                             ( $tagsval ) $search
                             and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where)
                             UNION (
                             SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                             peinvestments_advisorcompanies AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.$wheredates1.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID and 
                             ( $tagsval ) $search and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where) order by Cianame";

                            $totalallsql=$exportsql=$showallsql;

                        }
                        elseif($searchallfield!="")
                        {
                            $findTag = strpos($searchallfield,'tag:');
                             $findTags = "$findTag";
                             if($findTags == ''){
                                 $tagsval = "cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%' or c.tags like '%$searchallfield%'";                                    
                             }else{
                                 $tags = '';
                                 $ex_tags = explode(',',$searchallfield);
                                 if(count($ex_tags) > 0){
                                     for($l=0;$l<count($ex_tags);$l++){
                                         if($ex_tags[$l] !=''){
                                             $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                             $tags .= "c.tags like '%:$value%' or ";
                                         }
                                     }
                                 }
                                 $tagsval = trim($tags,' or ');
                             }
                            $showallsql="(
                             SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                             peinvestments_advisorinvestors AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID and 
                             ( $tagsval ) $search
                             and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where)
                             UNION (
                             SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                             FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                             peinvestments_advisorcompanies AS adac, stage as s
                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
                             " AND c.PECompanyId = pe.PECompanyId
                             AND adac.CIAId = cia.CIAID and 
                             ( $tagsval ) $search and AdvisorType='".$adtype ."'
                             AND adac.PEId = pe.PEId $comp_industry_id_where) order by Cianame";

                            $totalallsql=$exportsql=$showallsql;
                         }
                        else
                        {

                         $companysql= "(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorinvestors AS adac,stage as s where c.RegionId=re.RegionId and";
                         $companysql2= "SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,stage as s where c.RegionId=re.RegionId and";


                         if ($industry > 0)
                             $whereind = " c.industry=" .$industry ;

                         if ($investorType!= "")
                             $whereInvType = " pe.InvestorType = '".$investorType."'";

                         if($city != "")
                         {
                             $whereCity=" c.city LIKE '%".$city."%'";
                         }
                         if ($boolStage==true)
                         {
                            $stagevalue="";
                            $stageidvalue="";
                            foreach($stageval as $stage)
                            {
                                    //echo "<br>****----" .$stage;
                                    $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                    $stageidvalue=$stageidvalue.",".$stage;
                            }

                            $wherestage = $stagevalue ;
                            $qryDealTypeTitle="Stage  - ";
                            $strlength=strlen($wherestage);
                            $strlength=$strlength-3;
                            //echo "<Br>----------------" .$wherestage;
                            $wherestage= substr ($wherestage , 0,$strlength);
                            $wherestage ="(".$wherestage.")";
                            //echo "<br>---" .$stringto;

                         }
                           //
                         if($round != "--" && $round !="")
                         {
                             $whereRound=" pe.round LIKE '".$round."'";
                         }
                                     //   
                         if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                         {
                                 $startRangeValue=$startRangeValue;
                                 $endRangeValue=$endRangeValue-0.01;
                                 $qryRangeTitle="Deal Range (M$) - ";
                                 if($startRangeValue < $endRangeValue)
                                 {
                                         $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                 }
                                 elseif($startRangeValue = $endRangeValue)
                                 {
                                         $whererange = " pe.amount >= ".$startRangeValue ."";
                                 }
                         }

                         if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                              $dt1 = $year1."-".$month1."-01";
                              $dt2 = $year2."-".$month2."-01";
                              $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                         }



                         if ($whereind != "")
                         {
                                 $companysql=$companysql . $whereind ." and ";
                                 $companysql2=$companysql2 . $whereind ." and ";
                         }

                         if ($whereInvType != "")
                         {
                                 $companysql=$companysql . $whereInvType ." and ";
                                 $companysql2=$companysql2 . $whereInvType ." and ";
                         }

                         if (($wherestage != ""))
                         {
                                 $companysql=$companysql . $wherestage . " and " ;
                                 $companysql2=$companysql2 . $wherestage . " and " ;

                         }

                             if($whereRound !="")
                                     {
                                         $companysql=$companysql.$whereRound." and ";
                                         $companysql2=$companysql2.$whereRound." and ";
                                     }       
                         if (($whererange != "") )
                         {
                                 $companysql=$companysql .$whererange . " and ";
                                 $companysql2=$companysql2 .$whererange . " and ";
                         }


                         if(($wheredates !== "") )
                         {
                                 $companysql = $companysql.$wheredates ." and ";
                                 $companysql2 = $companysql2.$wheredates ." and ";
                         }

                         if($whereCity !="")
                         {
                             $companysql=$companysql.$whereCity." and ";
                             $companysql2 = $companysql2.$whereCity ." and ";
                         }

                         $companysqltot = $companysql ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                             AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall."
                             AND adac.PEId = pe.PEId $comp_industry_id_where";
                         $companysqltot2 = $companysql2 ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                             AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall."
                             AND adac.PEId = pe.PEId $comp_industry_id_where";

                         $companysql = $companysql ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                             AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall."
                             AND adac.PEId = pe.PEId $comp_industry_id_where";
                         $companysql2 = $companysql2 ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                             AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall."
                             AND adac.PEId = pe.PEId $comp_industry_id_where";



                         $showallsql=$companysql.") UNION (".$companysql2.") ";
                          $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";

                         $orderby="order by Cianame";       

                         $showallsql=$showallsql.$orderby;
                         $totalallsql=$totalallsql.$orderby;
                         $exportsql = $totalallsql;
                         //echo $showallsql;

                         }

                     }
                }
                else if($vcflagValue==2)
                {
                    if($dealvalue==101)
                    {
                        /*if($keyword!="")
                         {
                                 $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                 FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                 WHERE pe.InvesteeId = pec.PEcompanyId
                                 AND pec.industry !=15
                                 AND peinv.AngelDealId = pe.AngelDealId
                                 AND inv.InvestorId = peinv.InvestorId
                                 AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";

                                 $totalallsql = $showallsql;
                             //echo "<br> Investor search- ".$showallsql;
                         }
                        else*/
                       if($companysearch!="")
                        {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c where 
                                pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                                AND pec.industry !=15 AND peinv.AngelDealId = pe.AngelDealId
                                AND inv.InvestorId = peinv.InvestorId 
                                AND pe.Deleted=0 and pec.companyname like '%$companysearch%' $comp_industry_id_where order by inv.Investor ";

                                $totalallsql=$exportsql=$showallsql;
                            //echo "<br> company search-0 or 1 ".$showallsql;
                        }   
                        elseif($tagsearch != ""){
                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                            }else{
                                $wheredates= "";
                            }
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                     FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c
                                     WHERE pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                                     AND pec.industry !=15
                                     AND peinv.AngelDealId = pe.AngelDealId
                                     AND inv.InvestorId = peinv.InvestorId
                                     AND pe.Deleted=0 " .$addVCFlagqry.$wheredates. " and ( $tagsval ) $comp_industry_id_where order by inv.Investor ";

                                 $totalallsql = $exportsql= $showallsql; 
                        }  
                        elseif($searchallfield!="")
                        {


                            $findTag = strpos($searchallfield,'tag:');
                             $findTags = "$findTag";
                             if($findTags == ''){
                                 $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                             }else{
                                 $tags = '';
                                 $ex_tags = explode(',',$searchallfield);
                                 if(count($ex_tags) > 0){
                                     for($l=0;$l<count($ex_tags);$l++){
                                         if($ex_tags[$l] !=''){
                                             $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                             $tags .= "pec.tags like '%:$value%' or ";
                                         }
                                     }
                                 }
                                 $tagsval = trim($tags,' or ');
                             }
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                     FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c
                                     WHERE pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                                     AND pec.industry !=15
                                     AND peinv.AngelDealId = pe.AngelDealId
                                     AND inv.InvestorId = peinv.InvestorId
                                     AND pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) $comp_industry_id_where order by inv.Investor ";

                                 $totalallsql = $exportsql= $showallsql; 
                        }
                        else
                        {
                             
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                     FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c where ";
                            
                             //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0){
                                $whereind = " pec.industry=" .$industry ;
                            }

                            if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                            
                                if (count($countryNINtxt) > 0 && $country_value_check == 1) //T-966 changes
                                {
                                    if($countryNINtxt[0] == 'All'){//T-966 changes
                                        $wherecountryNIN = " inv.countryid != 'IN'" ;
                                    } else {
                                        $wherecountryNIN = " inv.countryid IN (".$countryid_code.")" ;
                                    }
                                }
                            
                            if (count($cityname_list) > 0 && $cityid[0] != "--")
                            $wherecitytxt = " inv.City IN (".$cityname_list.")";

                            if (($followonVCFund =="3") || ($followonVCFund=="1"))
                            {
                                $wherefollowonVCFund = " pe.FollowonVCFund = ".$followonVCFund;
                                $qryDealTypeTitle="Follow on Funding Status  - ";
                            }
                            if (($exited=="3") || ($exited=="1"))
                            {
                                $whereexited = " pe.Exited =".$exited;
                                $qryDealTypeTitle="Exited  - ";
                            }
                            if (count($txtregion) > 0)
                            {
                                $region_Sql = '';
                                foreach($txtregion as $regionIds)
                                {
                                    $region_Sql .= " pec.RegionId  =$regionIds or ";
                                }
                                $roundSqlStr = trim($region_Sql,' or ');
                                $qryRegionTitle="Region - ";
                                if($roundSqlStr !=''){
                                    $whereregion = '('.$roundSqlStr.')';
                                }
                                $qryDealTypeTitle="Region  - ";
                            }
                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                            }
                            
                            if($city != "")
                            {
                                   $whereCity=" pec.city LIKE '".$city."'";
                            }
                            
                            
                            if ($whereind != "")
                            {
                                    $showallsql=$showallsql . $whereind ." and ";
                                    $bool=true;
                            }
                            else
                            {
                                    $bool=false;
                            }
                             
                            if($wherefollowonVCFund!=""){
                                $showallsql=$showallsql .$wherefollowonVCFund. " and ";
                            }
                            if($whereexited !=""){
                                $showallsql=$showallsql .$whereexited. " and ";
                            }
                            if($whereregion !=""){
                                $showallsql=$showallsql .$whereregion. " and ";
                            }
                            if($whereCity !="")
                            {
                                $showallsql=$showallsql.$whereCity." and ";
                            }
                            if ($wherecountry != "")
                             {
                                     $showallsql=$showallsql . $wherecountry ." and ";
                                     $bool=true;
                             }
                             if ($wherecountryNIN != "")
                             {
                                     $showallsql=$showallsql . $wherecountryNIN ." and ";
                                     $bool=true;
                             }
                             if ($wherecitytxt != "")
                             {
                                     $showallsql=$showallsql . $wherecitytxt ." and ";
                                     $bool=true;
                             }

                            if(($wheredates !== "") )
                            {
                                    $showallsql = $showallsql . $wheredates ." and ";
                                    $bool=true;
                            }
                            
                            $totalallsql = $exportsql = $showallsql. " pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                                     AND pec.industry !=15
                                     AND peinv.AngelDealId = pe.AngelDealId
                                     AND inv.InvestorId = peinv.InvestorId
                                     AND pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " ".$dirsearchall." $comp_industry_id_where order by inv.Investor ";
                            $showallsql = $showallsql. " pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                                     AND pec.industry !=15
                                     AND peinv.AngelDealId = pe.AngelDealId
                                     AND inv.InvestorId = peinv.InvestorId
                                     AND pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " " .$search." ".$dirsearchall." $comp_industry_id_where order by inv.Investor ";

                            
                           /*  $totalallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                             pe.StageId=s.StageId and pec.industry!=15 and
                             pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall."  order by inv.Investor ";

                             $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                             pe.StageId=s.StageId and pec.industry!=15 and
                             pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                                /* $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                     FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                     WHERE pe.InvesteeId = pec.PEcompanyId
                                     AND pec.industry !=15
                                     AND peinv.AngelDealId = pe.AngelDealId
                                     AND inv.InvestorId = peinv.InvestorId
                                     AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall." order by inv.Investor ";

                                 $totalallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                     FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                     WHERE pe.InvesteeId = pec.PEcompanyId
                                     AND pec.industry !=15
                                     AND peinv.AngelDealId = pe.AngelDealId
                                     AND inv.InvestorId = peinv.InvestorId
                                     AND pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall." order by inv.Investor ";*/
                        }
                    }
                    else if($dealvalue==102)
                    {
                        $companynamefilter="and pec.companyname NOT LIKE '%Undisclosed%' and pec.companyname NOT LIKE '%Unknown%' and pec.companyname NOT LIKE '%Others%'";
                        if($keyword!="")
                        {
                                 $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                 FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                 WHERE pe.InvesteeId = pec.PEcompanyId
                                 AND pec.industry !=15
                                 AND peinv.AngelDealId = pe.AngelDealId
                                 AND inv.InvestorId = peinv.InvestorId
                                 AND pe.Deleted=0 " .$companynamefilter.$addVCFlagqry. " and Investor like '%$keyword%' $comp_industry_id_where order by inv.Investor ";

                                 $totalallsql = $exportsql = $showallsql;
                             //echo "<br> Investor search- ".$showallsql;
                        }
                        elseif($tagsearch != ""){
                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                            }else{
                                $wheredates= "";
                            }
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                            $showallsql  = "SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                     FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                     WHERE pec.PECompanyId = pe.InvesteeId 
                                     AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId and ( $tagsval )  " .$companynamefilter.$addVCFlagqry.$wheredates. " " .$search." ".$dirsearchall.$comp_industry_id_where."
                                         ORDER BY pec.companyname";

                             $totalallsql = $exportsql ="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                         FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                         WHERE pec.PECompanyId = pe.InvesteeId 
                                         AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId and ( $tagsval )  " .$companynamefilter.$addVCFlagqry.$wheredates. " ".$dirsearchall.$comp_industry_id_where."
                                         ORDER BY pec.companyname";
                        } 
                        elseif($searchallfield!="")
                        {
                            $findTag = strpos($searchallfield,'tag:');
                             $findTags = "$findTag";
                             if($findTags == ''){
                                 $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                         OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%' or";                                    
                             }else{
                                 $tags = '';
                                 $ex_tags = explode(',',$searchallfield);
                                 if(count($ex_tags) > 0){
                                     for($l=0;$l<count($ex_tags);$l++){
                                         if($ex_tags[$l] !=''){
                                             $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                             $tags .= "pec.tags like '%:$value%' or ";
                                         }
                                     }
                                 }
                                 $tagsval = trim($tags,' or ');
                             }
                            $showallsql  = "SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                     FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                     WHERE pec.PECompanyId = pe.InvesteeId 
                                     AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId and ( $tagsval )  " .$companynamefilter.$addVCFlagqry. " " .$search." ".$dirsearchall.$comp_industry_id_where."
                                         ORDER BY pec.companyname";

                             $totalallsql = $exportsql ="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                         FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                         WHERE pec.PECompanyId = pe.InvesteeId 
                                         AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId and ( $tagsval )  " .$companynamefilter.$addVCFlagqry. " ".$dirsearchall.$comp_industry_id_where."
                                         ORDER BY pec.companyname";
                         }
                        else
                        {
                             
                            $showallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                         FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r WHERE ";
                             
                             
                            if ($industry > 0)
                                $whereind = " pec.industry=" .$industry ;

                            if (($followonVCFund =="3") || ($followonVCFund=="1"))
                            {
                                $wherefollowonVCFund = " pe.FollowonVCFund = ".$followonVCFund;
                                $qryDealTypeTitle="Follow on Funding Status  - ";
                            }
                            if (($exited=="3") || ($exited=="1"))
                            {
                                $whereexited = " pe.Exited =".$exited;
                                $qryDealTypeTitle="Exited  - ";
                            }
                            if (count($txtregion) > 0)
                            {
                                $region_Sql = '';
                                foreach($txtregion as $regionIds)
                                {
                                    $region_Sql .= " pec.RegionId  =$regionIds or ";
                                }
                                $roundSqlStr = trim($region_Sql,' or ');
                                $qryRegionTitle="Region - ";
                                if($roundSqlStr !=''){
                                    $whereregion = '('.$roundSqlStr.')';
                                }
                                $qryDealTypeTitle="Region  - ";
                            }
                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                            }
                            
                            if($city != "")
                            {
                                   $whereCity=" pec.city LIKE '".$city."'";
                            }

                            if ($whereind != "")
                            {
                                   $showallsql=$showallsql . $whereind ." and ";
                                   $bool=true;
                            }
                            else
                            {
                                   $bool=false;
                            }
                             
                            if($wherefollowonVCFund!=""){
                                $showallsql=$showallsql .$wherefollowonVCFund. " and ";
                            }
                            if($whereexited !=""){
                                $showallsql=$showallsql .$whereexited. " and ";
                            }
                            if($whereregion !=""){
                                $showallsql=$showallsql .$whereregion. " and ";
                            }
                            if(($wheredates !== "") )
                            {
                                    $showallsql = $showallsql . $wheredates ." and ";
                                    $bool=true;
                            }
                            if($whereCity !="")
                            {
                                $showallsql=$showallsql.$whereCity." and ";
                            }
                            
                            $totalallsql = $exportsql = $showallsql."pec.PECompanyId = pe.InvesteeId 
                                     AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                 AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. " ".$dirsearchall.$comp_industry_id_where."
                                 ORDER BY pec.companyname";
                            
                           $showallsql = $showallsql."pec.PECompanyId = pe.InvesteeId 
                                     AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                 AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. " " .$search." ".$dirsearchall.$comp_industry_id_where."
                                 ORDER BY pec.companyname";

                            /*$totalallsql = $exportsql ="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                 FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                 WHERE pec.PECompanyId = pe.InvesteeId 
                                 AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                 AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall."
                                 ORDER BY pec.companyname";*/

                    }
                    }    
                    else if($dealvalue==110)
                    {
                        $Angelfilter='';


                        if(isset($_POST['angelsearchtype'])){
                          $Angelfilter='';

                            if($_POST['angelsearchtype']==1 && $_REQUEST['company_location'] !=''){

                                 $loc = $_REQUEST['company_location'];
                                 $Angelfilter .= "  a.company_name LIKE '$loc%' OR a.location LIKE '$loc%' ";

                            }else if($_POST['angelsearchtype']==2 && $_REQUEST['raising_amount'] !=''){
                                 $raising_amount = $_REQUEST['raising_amount']*1000;

                                 $Angelfilter .= "  a.raising_amount >= '$raising_amount'  ";
                            }
                        }





                         if( isset($_GET['s'])){

                             $Angelfilter='';
                             $_REQUEST['company_location']=$_REQUEST['raising_amount']=$raising_amount='';
                             $char =  $_GET['s'];

                             if($char!=''){


                                    if($Angelfilter=='')
                                          $Angelfilter .= "  a.company_name LIKE '$char%'  AND a.raising_amount >= 10000  ";                                        
//                                       else
//                                             $Angelfilter .= "  AND  a.company_name LIKE '$char%'  ";  


                             }

                         }



                         if($raising_amount>0){
                             $raising = " AND a.raising_amount >= $raising_amount ";
                         }else{
                              $raising = "";
                         }


                        // echo $Angelfilter; exit;

                         if($searchallfield != ''){
                         if(!isset($_GET['s']) && $Angelfilter==''){
                                        $Angelfilter = " a.raising_amount >= 10000   ";
                             }
                         }else{
                             if(!isset($_GET['s']) && $Angelfilter==''){
                                    $Angelfilter = " a.company_name LIKE 'a%'  AND a.raising_amount >= 10000   ";
                         }
                         }

                         if($Angelfilter!=''){
                               $Angelfilter = " WHERE ". $Angelfilter. " $raising";
                         }      

                         if($searchallfield!="")
                         {
                             $angelCosql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $Angelfilter and ( p.city LIKE '$searchallfield%' or a.company_name LIKE '$searchallfield%'
                                         OR p.sector_business LIKE '%$searchallfield%' or p.AdditionalInfor like '%$searchallfield%' ) $comp_industry_id_where ORDER BY a.company_name";
                              $totalallsql = $angelCosql;
                         }else{
                             
                            //$angelCosql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $Angelfilter  ORDER BY a.company_name";
                            $angelCosql = "SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $Angelfilter ";
                                
                               
                               $angelCosql = $angelCosql." ORDER BY a.company_name";
                            $totalallsql = $angelCosql;
                         }
                    }
                  /*  else if($dealvalue==110)
                    {
                           $Angelfilter='';
                        
                            if(isset($_POST['angelsearchtype'])){
                              $Angelfilter='';

                                if($_POST['angelsearchtype']==1 && $_REQUEST['company_location'] !=''){

                                     $loc = $_REQUEST['company_location'];
                                     $Angelfilter .= "  a.company_name LIKE '$loc%' OR a.location LIKE '$loc%' ";

                                }else if($_POST['angelsearchtype']==2 && $_REQUEST['raising_amount'] !=''){
                                     $raising_amount = $_REQUEST['raising_amount']*1000;

                                     $Angelfilter .= "  a.raising_amount >= '$raising_amount'  ";
                                }
                            }
                         
                            if( isset($_GET['s'])){
                               
                                $Angelfilter='';
                                $_REQUEST['company_location']=$_REQUEST['raising_amount']=$raising_amount='';
                                $char =  $_GET['s'];
                              
                                if($char!=''){
                                    
                                    
                                    if($Angelfilter=='')
                                          $Angelfilter .= "  a.company_name LIKE '$char%'  AND a.raising_amount >= 10000  ";                                        
//                                       else
//                                             $Angelfilter .= "  AND  a.company_name LIKE '$char%'  ";  
                                       
                                       
                                }

                            }
                            
                            if($raising_amount>0){
                                $raising = " AND a.raising_amount >= $raising_amount ";
                            }else{
                                 $raising = "";
                            }
                              
                           // echo $Angelfilter; exit;
                            
                            if($searchallfield != ''){
                                if(!isset($_GET['s']) && $Angelfilter==''){
                                    $Angelfilter = " a.raising_amount >= 10000   ";
                                }
                            }else{
                                if(!isset($_GET['s']) && $Angelfilter==''){
                                    $Angelfilter = " a.company_name LIKE 'a%'  AND a.raising_amount >= 10000   ";
                                }
                            }
                            
                            if($Angelfilter!=''){
                                  $Angelfilter = " WHERE ". $Angelfilter. " $raising";
                            }      
                            if($keyword!="")
                            {
                                    $showallsql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $Angelfilter and ( p.city LIKE '$searchallfield%' or a.company_name LIKE '$searchallfield%'
                                            OR p.sector_business LIKE '%$searchallfield%' or p.AdditionalInfor like '%$searchallfield%' )  ORDER BY a.company_name";

                                    $totalallsql = $showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $showallsql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $Angelfilter and ( p.city LIKE '$searchallfield%' or a.company_name LIKE '$searchallfield%'
                                            OR p.sector_business LIKE '%$searchallfield%' or p.AdditionalInfor like '%$searchallfield%' )  ORDER BY a.company_name";
                            }
                            else
                            {
                                
                                $showallsql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $Angelfilter "; 
                                   
                                 if ($industry > 0)
                                    $whereind = " p.industry=" .$industry ;

                                if (count($txtregion) > 0)
                                {
                                    $region_Sql = '';
                                    foreach($txtregion as $regionIds)
                                    {
                                        $region_Sql .= " p.RegionId  =$regionIds or ";
                                    }
                                    $roundSqlStr = trim($region_Sql,' or ');
                                    $qryRegionTitle="Region - ";
                                    if($roundSqlStr !=''){
                                        $whereregion = '('.$roundSqlStr.')';
                                    }
                                    $qryDealTypeTitle="Region  - ";
                                }
                                
                                if($city != "")
                                {
                                       $whereCity=" p.city LIKE '%".$city."'%";
                                }
                               
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";
                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                               if($whereregion !=""){
                                   $showallsql=$showallsql .$whereregion. " and ";
                               }
                               if($whereCity !="")
                               {
                                   $showallsql=$showallsql.$whereCity." and ";
                               }
                                
                                $showallsql = $showallsql." ORDER BY a.company_name";
                            }
                    }*/
                       
                }
                elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
                {if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates1 = " and dates between '" . $dt1. "' and '" . $dt2 . "' ";
                           }
                    if($dealvalue==101)
                    {
                        if($vcflagValue==3){
                            $firmtype = " and inv.FirmTypeId = 4";
                        }
                           if($keyword!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry.  $firmtype .$wheredates1. " and Investor like '%$keyword%' $comp_industry_id_where order by inv.Investor ";
                                //echo "<br> Investor search- ".$showallsql;
                                    $totalallsql = $exportsql =$showallsql;
                                    
                            }
                            elseif($companysearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry.  $firmtype .$wheredates1. " and pec.companyname like '%$companysearch%' $comp_industry_id_where order by inv.Investor ";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. $firmtype . $wheredates1." and pec.sector_business like '%$sectorsearch%' $comp_industry_id_where order by inv.Investor ";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. $firmtype .$wheredates1. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' $comp_industry_id_where order by inv.Investor)
                                        UNION(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorcompanies AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry.  $firmtype .$wheredates1. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' $comp_industry_id_where order by inv.Investor)";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                   $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. $firmtype .$wheredates1. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' $comp_industry_id_where order by inv.Investor)
                                        UNION(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorcompanies AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. $firmtype . $wheredates1. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' $comp_industry_id_where order by inv.Investor)";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            }
                            elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                                
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry.  $firmtype .$wheredates1. " and ( $tagsval ) $search $comp_industry_id_where order by inv.Investor ";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry.  $firmtype .$wheredates1. " and ( $tagsval ) $search $comp_industry_id_where order by inv.Investor ";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                            else
                            {
                              $showallsql = "select distinct peinv.InvestorId,inv.Investor,inv.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb where ";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";

                                if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                        $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                                    
                                        if (count($countryNINtxt) > 0 && $country_value_check == 1)//T-966 changes
                                        {
                                            if($countryNINtxt[0] == 'All'){ //T-966 changes
                                                $wherecountryNIN = " inv.countryid != 'IN'" ;
                                            } else {
                                                $wherecountryNIN = " inv.countryid IN (".$countryid_code.")" ;
                                            }
                                        }
                                    
                                if (count($cityname_list) > 0 && $cityid[0] != "--")
                                $wherecitytxt = " inv.City IN (".$cityname_list.")";
                                
                                if ($firmtypetxt!= "" && $firmtypetxt != "--")
                                        $wherefirmtypetxt = " inv.FirmTypeId IN (".$firmtypevalue.")";

                                if($city != "")
                                {
                                       $whereCity=" pec.city LIKE '".$city."'";
                                }
                             
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                if($round != "--" && $round !="")
                                {
                                    $whereRound="pe.round LIKE '".$round."'";
                                }
                                        //
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql.$whereRound." and ";
                                        }     
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($wherefirmtypetxt != "") )
                                {
                                        $showallsql=$showallsql.$wherefirmtypetxt . " and ";
                                        $bool=true;
                                }

                                if ($wherecountry != "")
                                {
                                         $showallsql=$showallsql . $wherecountry ." and ";
                                         $bool=true;
                                }
                                if ($wherecountryNIN != "")
                                {
                                         $showallsql=$showallsql . $wherecountryNIN ." and ";
                                         $bool=true;
                                }
                                if ($wherecitytxt != "")
                                {
                                         $showallsql=$showallsql . $wherecitytxt ." and ";
                                         $bool=true;
                                }
                                
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                                if($whereCity !="")
                                {
                                    $showallsql=$showallsql.$whereCity." and ";
                                }
                                
                                $totalallsql = $exportsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. $firmtype .  " ".$dirsearchall.$comp_industry_id_where."  order by inv.Investor ";
                                 
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. $firmtype .  " " .$search." ".$dirsearchall.$comp_industry_id_where."  order by inv.Investor ";
                                
                               
                            }
                    }
                    else if($dealvalue==111)
                    {
                        if($vcflagValue==3){
                            $firmtype = " and inv.FirmTypeId = 4";
                        }
                        if($keyworddir!="")
                         {
                            /*$showallsql="select distinct lp.*
                            from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i,limited_partners as lp
                            where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                            pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and
                            pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1" .$addVCFlagqry. " and inv.Investor like '%$keyword%' $comp_industry_id_where  GROUP BY lp.LPId order by lp.InstitutionName ";*/
                            $showallsql="select distinct lp.*
                            from peinvestors as inv,limited_partners as lp,peinvestments_dbtypes as pedb,peinvestments as pe,peinvestments_investors as peinv
                            where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, trim(REPLACE( inv.LimitedPartners,', ',','))) and lp.Deleted!=1" .$addVCFlagqry. " and inv.Investor like '%$keyworddir%'  GROUP BY lp.LPId order by lp.InstitutionName ";

                            $totalallsql=$exportsql=$showallsql;
                             //echo "<br> Investor search 0 or 1- ".$showallsql;
                         }  elseif($searchallfield!="")
                            {
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                    $showallsql="select distinct lp.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,
                                    peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1" .$addVCFlagqry.  $firmtype . " and ( $tagsval ) $search $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName ";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                           else
                         {
                            if($vcflagValue==1)
                            {
                                $joinvctable=" ,peinvestments as pe   ";
                                $vccondition=" and pe.amount<=20 ";
                            }else{
                                $joinvctable="";
                                $vccondition="";
                            }

                            // $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                            //  where    inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                            //  ";
                            
                             $showallsql = "select distinct lp.*
                             from peinvestors as inv,limited_partners as lp,peinvestments_dbtypes as pedb,peinvestments as pe,peinvestments_investors as peinv
                             where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, trim(REPLACE( inv.LimitedPartners,', ',','))) and lp.Deleted!=1".$search .$addVCFlagqry .$dirsearchall.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                             ";
                             $totalallsql=$exportsql=$showallsql;  

                            
                         }
                    } 
                    else if($dealvalue==102)
                    {
                        $companynamefilter="and pec.companyname NOT LIKE 'Undisclosed%' and pec.companyname NOT LIKE 'Unknown%' and pec.companyname NOT LIKE 'Others%'";
                        if($companysearch!="")
                        {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. " and pec.companyname LIKE '%$companysearch%' $comp_industry_id_where ORDER BY pec.companyname";

                                $totalallsql= $exportsql =$showallsql;
                            //echo "<br> Investor search- ".$showallsql;
                        }
                        elseif($keyword!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM peinvestments_investors as peinv,pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestors as inv,peinvestments_dbtypes as pedb
                                            WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. $wheredates1."  and Investor like '%$keyword%' $comp_industry_id_where  ORDER BY pec.companyname";
                              
                                    $totalallsql = $exportsql =$showallsql;
                                      //echo "<br> Investor search- ".$showallsql;
                                    
                            }
                            elseif($sectorsearch!="")
                            {
                                     $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. $wheredates1." and pec.sector_business LIKE '%$sectorsearch%' $comp_industry_id_where ORDER BY pec.companyname";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                               // echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                     $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorinvestors AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. "  and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' $comp_industry_id_where ORDER BY pec.companyname
                                            )
                                        UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorcompanies AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. "  and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' $comp_industry_id_where ORDER BY pec.companyname
                                            )";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorinvestors AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. "  and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' $comp_industry_id_where ORDER BY pec.companyname
                                            )
                                        UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorcompanies AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. $wheredates1."  and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' $comp_industry_id_where ORDER BY pec.companyname
                                            )";
                                    
                                    $totalallsql = $exportsql = $showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            } elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. " and ( $tagsval ) $search $comp_industry_id_where ORDER BY pec.companyname";

                                $totalallsql = $exportsql =$showallsql;

                            }


                            else if($searchallfield !=''){
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry.$wheredates1. " and ( $tagsval ) $search $comp_industry_id_where ORDER BY pec.companyname";

                                $totalallsql = $exportsql =$showallsql;
                            }
                        else
                        {
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, peinvestments_investors AS peinv , peinvestors AS inv
                                            WHERE ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                    if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN") 
                                        $wherecountry = " inv.countryid = '" . $countrytxt . "'";
                                        if (count($countryNINtxt) > 0 && $country_value_check == 1) //T-966 changes
                                        {
                                            if($countryNINtxt[0] == 'All'){ //T-966 changes
                                                $wherecountryNIN = " inv.countryid != 'IN'" ;
                                            } else {
                                                $wherecountryNIN = " inv.countryid IN (".$countryid_code.")" ;
                                            }
                                        }
                                    if (count($cityname_list) > 0 && $cityid[0] != "--") 
                                    $wherecitytxt = " inv.City IN (".$cityname_list.")";

                                if($city != "")
                                {
                                    $whereCity=" pec.city LIKE '".$city."'";
                                }
                                            
                                if ($boolStage==true)
                                {
                                    $stagevalue="";
                                    $stageidvalue="";
                                    foreach($stageval as $stage)
                                    {
                                            //echo "<br>****----" .$stage;
                                            $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                            $stageidvalue=$stageidvalue.",".$stage;
                                    }

                                    $wherestage = $stagevalue ;
                                    $qryDealTypeTitle="Stage  - ";
                                    $strlength=strlen($wherestage);
                                    $strlength=$strlength-3;
                                    //echo "<Br>----------------" .$wherestage;
                                    $wherestage= substr ($wherestage , 0,$strlength);
                                    $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                if($round != "--" && $round !="")
                                {
                                    $whereRound="pe.round LIKE '".$round."'";
                                }
                                        //
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql.$whereRound." and ";
                                        }  
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                                if ($wherecountry != "") {
                                    $showallsql = $showallsql . $wherecountry . " and ";
                                    $bool = true;
                                }
                                if ($wherecountryNIN != "") {
                                    $showallsql = $showallsql . $wherecountryNIN . " and ";
                                    $bool = true;
                                }
                                if ($wherecitytxt != "") {
                                    $showallsql = $showallsql . $wherecitytxt . " and ";
                                    $bool = true;
                                }
                                if($whereCity !="")
                                {
                                    $showallsql=$showallsql.$whereCity." and ";
                                    $bool=true;
                                }
                               
                                $totalallsql = $exportsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. " ".$dirsearchall.$comp_industry_id_where."
                                            ORDER BY pec.companyname";
                                 
                                $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$companynamefilter.$addVCFlagqry. " " .$search." ".$dirsearchall.$comp_industry_id_where."
                                            ORDER BY pec.companyname";
                        }
                     }
                    else if($dealvalue==104 || $dealvalue==103)
                    {
                         if($_SESSION['PE_industries']!=''){

                            $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
                        }
                  
                            if($advisorsearch_trans!="")
                            {
                                $showallsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where )
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where ) order by Cianame";
                                //echo "<br> Investor search- ".$showallsql;
                                $totalallsql = $exportsql =$showallsql;
                                
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                
                                $showallsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where) order by Cianame";
                                //echo "<br> Investor search- ".$showallsql;
                                $totalallsql = $exportsql =$showallsql;
                                
                            }
                            elseif($companysearch!="")
                            {
                                 $showallsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where) order by Cianame";

                                $totalallsql = $exportsql =$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            elseif($keyword!="")
                            {
                                 $showallsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments_investors as pe,peinvestments AS peinv, pecompanies AS c,peinvestors as inv, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                WHERE pe.PEId=peinv.PEId and inv.InvestorId=pe.InvestorId and peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments_investors as pe,peinvestments AS peinv, pecompanies AS c,peinvestors as inv,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                WHERE  pe.PEId=peinv.PEId and inv.InvestorId=pe.InvestorId and peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where) order by Cianame";
                              
                                $totalallsql = $exportsql =$showallsql;
                                     // echo "<br> Investor search- ".$showallsql;
                                    
                            }
                            elseif($sectorsearch!="")
                            {
                                 $showallsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId $comp_industry_id_where) order by Cianame";
                                    
                                $totalallsql = $exportsql =$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(c.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(c.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                        FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                                        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                                        WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.$wheredates1.
                                        " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                        AND adac.CIAId = cia.CIAID  and ( $tagsval ) and AdvisorType='".$adtype ."'
                                        AND adac.PEId = peinv.PEId  and AdvisorType='".$adtype ."' $search
                                        AND adac.PEId = peinv.PEId $comp_industry_id_where)
                                        UNION (
                                        SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                        FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                                        WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.$wheredates1.
                                        " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                        AND adac.CIAId = cia.CIAID  and ( $tagsval ) and AdvisorType='".$adtype ."' $search
                                        AND adac.PEId = peinv.PEId $comp_industry_id_where) order by Cianame";
                               
                                $totalallsql = $exportsql =$showallsql;
                            }


                            elseif($searchallfield!="")
                            {
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%' or c.tags like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "c.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                               $showallsql="(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and ( $tagsval ) and AdvisorType='".$adtype ."'
                AND adac.PEId = peinv.PEId  and AdvisorType='".$adtype ."' $search
                AND adac.PEId = peinv.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.$wheredates1.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and ( $tagsval ) and AdvisorType='".$adtype ."' $search
                AND adac.PEId = peinv.PEId $comp_industry_id_where) order by Cianame";
                               
                                $totalallsql = $exportsql =$showallsql;
                                
                            }
                            else
                            {
                             
                                $companysql= "(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb WHERE c.RegionId=re.RegionId and";
                                $companysql2= "SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb WHERE c.RegionId=re.RegionId and";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " c.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " peinv.InvestorType = '".$investorType."'";
                                
                                if($city != "")
                                {
                                    $whereCity=" c.city LIKE '%".$city."%'";
                                }
                                if ($boolStage==true)
                                {
                                    $stagevalue="";
                                    $stageidvalue="";
                                    foreach($stageval as $stage)
                                    {
                                            //echo "<br>****----" .$stage;
                                            $stagevalue= $stagevalue. " peinv.StageId=" .$stage." or ";
                                            $stageidvalue=$stageidvalue.",".$stage;
                                    }

                                    $wherestage = $stagevalue ;
                                    $qryDealTypeTitle="Stage  - ";
                                    $strlength=strlen($wherestage);
                                    $strlength=$strlength-3;
                                    //echo "<Br>----------------" .$wherestage;
                                    $wherestage= substr ($wherestage , 0,$strlength);
                                    $wherestage ="(".$wherestage.")";
                                    //echo "<br>---" .$stringto;

                                }
                                //
                                if($round != "--" && $round !="")
                                {
                                    $whereRound="pe.round LIKE '".$round."'";
                                }
                                // 
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " peinv.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " peinv.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                            if ($whereind != "")
                            {
                                    $companysql=$companysql . $whereind ." and ";
                                    $companysql2=$companysql2 . $whereind ." and ";
                            }
                            
                            if ($whereInvType != "")
                            {
                                    $companysql=$companysql . $whereInvType ." and ";
                                    $companysql2=$companysql2 . $whereInvType ." and ";
                            }
                                        
                            if (($wherestage != ""))
                            {
                                    $companysql=$companysql . $wherestage . " and " ;
                                    $companysql2=$companysql2 . $wherestage . " and " ;

                            }
                                       
                                if($whereRound !="")
                                        {
                                            $companysql=$companysql . $whereRound . " and " ;
                                    $companysql2=$companysql2 . $whereRound . " and " ;
                                        }         
                            if (($whererange != "") )
                            {
                                    $companysql=$companysql .$whererange . " and ";
                                    $companysql2=$companysql2 .$whererange . " and ";
                            }
                                       
                                        
                            if(($wheredates != "") )
                            {
                                    $companysql = $companysql.$wheredates ." and ";
                                    $companysql2 = $companysql2.$wheredates ." and ";
                            }
                            
                            if($whereCity !="")
                            {
                                $companysql=$companysql.$whereCity." and ";
                                $companysql2 = $companysql2.$whereCity ." and ";
                                $bool=true;
                            }
                               
                            $companysqltot = $companysql ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall.$comp_industry_id_where." 
                AND adac.PEId = peinv.PEId ";
                            $companysqltot2 = $companysql2 ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall.$comp_industry_id_where." 
                AND adac.PEId = peinv.PEId ";
                            
                            $companysql = $companysql ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall.$comp_industry_id_where." 
                AND adac.PEId = peinv.PEId ";
                            $companysql2 = $companysql2 ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall.$comp_industry_id_where." 
                AND adac.PEId = peinv.PEId ";
                            
                            
                            
                            $showallsql=$companysql.") UNION (".$companysql2.") ";
                            $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";
       
                            $orderby="order by Cianame"; 
                            $showallsql=$showallsql.$orderby;
                            $totalallsql=$totalallsql.$orderby;
                            $exportsql = $totalallsql;
                            //echo $showallsql;
                            
                            }
                        }     
                }
                else if($vcflagValue==6)
                {
                    if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates1 = " and date_month_year between '" . $dt1. "' and '" . $dt2 . "' ";
                           }
                    if($dealvalue==105)
                    {

                         if($searchallfield !=''){
                            $findTag = strpos($searchallfield,'tag:');
                             $findTags = "$findTag";
                             if($findTags == ''){
                                 $tagsval = "inc.Incubator like '$searchallfield%' or inc.City LIKE '$searchallfield%'
                                         OR inc.AdditionalInfor like '%$searchallfield%' or inc.Address1 like '%$searchallfield%' or inc.Address2 like '%$searchallfield%' or inc.Zip like '%$searchallfield%' or inc.Telephone like '%$searchallfield%' or inc.Fax like '%$searchallfield%' or inc.Email like '%$searchallfield%' or inc.website like '%$searchallfield%' or inc.Management like '%$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
                             }else{
                                 $tags = '';
                                 $ex_tags = explode(',',$searchallfield);
                                 if(count($ex_tags) > 0){
                                     for($l=0;$l<count($ex_tags);$l++){
                                         if($ex_tags[$l] !=''){
                                             $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                             $tags .= "pec.tags like '%:$value%' or ";
                                         }
                                     }
                                 }
                                 $tagsval = trim($tags,' or ');
                             }
                        $showallsql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                             FROM incubatordeals AS pe,  incubators as inc, pecompanies AS pec
                                 WHERE inc.IncubatorId=pe.IncubatorId and pec.PECompanyId = pe.IncubateeId and pe.Deleted=0  and inc.Incubator != '' ".$wheredates1." and ( $tagsval ) ".$search." ".$dirsearchall.$comp_industry_id_where."
                              order by inc.Incubator ";

                        $totalallsql = $exportsql = "SELECT DISTINCT pe.IncubatorId, inc.*
                                  FROM incubatordeals AS pe,  incubators as inc, pecompanies AS pec
                                  WHERE inc.IncubatorId=pe.IncubatorId and pec.PECompanyId = pe.IncubateeId and pe.Deleted=0 ".$wheredates1." and ( $tagsval ) ".$dirsearchall.$comp_industry_id_where."
                                   order by inc.Incubator ";

                        }
                         elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                             FROM incubatordeals AS pe,  incubators as inc, pecompanies AS pec
                                 WHERE inc.IncubatorId=pe.IncubatorId and pec.PECompanyId = pe.IncubateeId and pe.Deleted=0  and inc.Incubator != '' ".$wheredates1." and ( $tagsval ) ".$search." ".$dirsearchall.$comp_industry_id_where."
                              order by inc.Incubator ";

                        $totalallsql = $exportsql = "SELECT DISTINCT pe.IncubatorId, inc.*
                                  FROM incubatordeals AS pe,  incubators as inc, pecompanies AS pec
                                  WHERE inc.IncubatorId=pe.IncubatorId and pec.PECompanyId = pe.IncubateeId and pe.Deleted=0 ".$wheredates1." and ( $tagsval ) ".$dirsearchall.$comp_industry_id_where."
                                   order by inc.Incubator ";
                        }
                        else{
                             $showallsql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                                FROM incubatordeals AS pe,  incubators as inc
                                WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0  and inc.Incubator != '' ".$search." ".$dirsearchall."
                                order by inc.Incubator ";
                             $totalallsql = $exportsql ="SELECT DISTINCT pe.IncubatorId, inc.*
                                FROM incubatordeals AS pe,  incubators as inc
                                WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 ".$dirsearchall."
                                order by inc.Incubator ";
                        }
                    }
                    else if($dealvalue==106)
                    {
                        $companynamefilter="and pec.companyname NOT LIKE '%Undisclosed%' and pec.companyname NOT LIKE '%Unknown%' and pec.companyname NOT LIKE '%Others%'";
                           if($searchallfield !=''){
                               
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%' ";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *
                FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry ".$wheredates1."
                                and pe.Deleted=0 ".$companynamefilter.$search." ".$dirsearchall." and pec.industry!=15 and ( $tagsval ) $comp_industry_id_where
                                ORDER BY pec.companyname";

                                $totalallsql = $exportsql ="SELECT DISTINCT pe.IncubateeId, pec. *
                                FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                                WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry ".$wheredates1."
                                and pe.Deleted=0 ".$companynamefilter.$dirsearchall." and pec.industry!=15 and ( $tagsval ) $comp_industry_id_where
                                ORDER BY pec.companyname";
                           }elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *
                FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry ".$wheredates1."
                                and pe.Deleted=0 ".$companynamefilter.$search." ".$dirsearchall." and pec.industry!=15 and ( $tagsval ) $comp_industry_id_where
                                ORDER BY pec.companyname";

                                $totalallsql = $exportsql ="SELECT DISTINCT pe.IncubateeId, pec. *
                                FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                                WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry ".$wheredates1."
                                and pe.Deleted=0 ".$companynamefilter.$dirsearchall." and pec.industry!=15 and ( $tagsval ) $comp_industry_id_where
                                ORDER BY pec.companyname";
                    }else{
                               
                                $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *
                                FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                                WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry ".$wheredates1."
                                and pe.Deleted=0 ".$companynamefilter.$search." ".$dirsearchall.$comp_industry_id_where." and pec.industry!=15
                                ORDER BY pec.companyname";
                            
                                $totalallsql = $exportsql ="SELECT DISTINCT pe.IncubateeId, pec. *
                FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry ".$wheredates1."
                                and pe.Deleted=0 ".$companynamefilter.$dirsearchall.$comp_industry_id_where." and pec.industry!=15
                ORDER BY pec.companyname";
                       }
                    }
                }
                elseif($vcflagValue==7 || $vcflagValue==8)
                {
                    if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates1 = " and IPODate between '" . $dt1. "' and '" . $dt2 . "' ";
                           }
                    if($dealvalue==101)
                    {

                        if($keyword!="")
                        {
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.IPOId = pe.IPOId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and Investor like '%$keyword%' $comp_industry_id_where order by inv.Investor ";

                            $totalallsql = $exportsql = $showallsql;
                             //echo "<br> sector search- ".$showallsql;
                        }
                        elseif($companysearch!="")
                        {
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.IPOId = pe.IPOId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and pec.companyname like '%$companysearch%' $comp_industry_id_where order by inv.Investor ";

                            $totalallsql = $exportsql =$showallsql;
                             //echo "<br> sector search- ".$showallsql;
                        }
                        elseif($sectorsearch!="")
                        {
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.IPOId = pe.IPOId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and pec.sector_business like '%$sectorsearch%' $comp_industry_id_where order by inv.Investor ";

                            $totalallsql = $exportsql =$showallsql;
                             //echo "<br> sector search- ".$showallsql;
                        }
                        elseif($searchallfield!="")
                        {
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv, country as c
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.IPOId = pe.IPOId
                            AND inv.InvestorId = peinv.InvestorId
                            and  inv.countryid= c.countryid 
                            AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%' ) order by inv.Investor ";

                            $totalallsql = $exportsql =$showallsql;
                             //echo "<br> sector search- ".$showallsql;  
                        }
                        elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv, country as c
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.IPOId = pe.IPOId
                            AND inv.InvestorId = peinv.InvestorId
                            and  inv.countryid= c.countryid 
                            AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and ($tagsval) order by inv.Investor ";

                            $totalallsql = $exportsql =$showallsql;
    }
                        else
                        {
                         $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                            WHERE ";

                            //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0)
                                    $whereind = " pec.industry=" .$industry ;

                            if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                    $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                            
                                    if (count($countryNINtxt) > 0 && $country_value_check == 1)//T-966 changes
                                    {
                                        if($countryNINtxt[0] == 'All'){//T-966 changes
                                            $wherecountryNIN = " inv.countryid != 'IN'" ;
                                        } else {
                                            $wherecountryNIN = " inv.countryid IN (".$countryid_code.")" ;
                                        }
                                    }
                                    
                            if (count($cityname_list) > 0 && $cityid[0] != "--")
                                    $wherecitytxt = " inv.City IN (".$cityname_list.")";

                            if ($investorType!= "")
                                    $whereInvType = " pe.InvestorType = '".$investorType."'";

                            if ($firmtypetxt!= "" && $firmtypetxt != "--")
                                    $wherefirmtypetxt = " inv.FirmTypeId IN (".$firmtypevalue.")";

                            if($city != "")
                             {
                                    $whereCity=" pec.city LIKE '".$city."'";
                             }
                             

                           if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                           {
                                   $startRangeValue=$startRangeValue;
                                   $endRangeValue=$endRangeValue-0.01;
                                   $qryRangeTitle="Deal Range (M$) - ";
                                   if($startRangeValue < $endRangeValue)
                                   {
                                           $whererange = " pe.IPOAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                   }
                                   elseif($startRangeValue = $endRangeValue)
                                   {
                                           $whererange = " pe.IPOAmount >= ".$startRangeValue ."";
                                   }
                           }

                           if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                           }

                           if(($wheredates != "") )
                           {
                                    $showallsql = $showallsql . $wheredates ." and ";
                                    $bool=true;
                           }

                            if ($whereind != "")
                            {
                                    $showallsql=$showallsql . $whereind ." and ";
                                    $bool=true;
                            }
                            else
                            {
                                    $bool=false;
                            }

                            if ($wherecountry != "")
                             {
                                     $showallsql=$showallsql . $wherecountry ." and ";
                                     $bool=true;
                             }
                             if ($wherecountryNIN != "")
                             {
                                     $showallsql=$showallsql . $wherecountryNIN ." and ";
                                     $bool=true;
                             }
                             if ($wherecitytxt != "")
                             {
                                     $showallsql=$showallsql . $wherecitytxt ." and ";
                                     $bool=true;
                             }

                            if (($whereInvType != "") )
                            {
                                    $showallsql=$showallsql.$whereInvType . " and ";
                                    $bool=true;
                            }
                            if (($wherefirmtypetxt != "") )
                            {
                                    $showallsql=$showallsql.$wherefirmtypetxt . " and ";
                                    $bool=true;
                            }
                            if (($whererange != "") )
                            {
                                    $showallsql=$showallsql.$whererange . " and ";
                                    $bool=true;
                            }
                            if($whereCity !="")
                            {
                                $showallsql=$showallsql.$whereCity." and ";
                            }

                            $totalallsql = $exportsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.IPOId = pe.IPOId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " ".$dirsearchall.$comp_industry_id_where."  order by inv.Investor ";

                            $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.IPOId = pe.IPOId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " " .$search." ".$dirsearchall.$comp_industry_id_where."  order by inv.Investor ";


                        }
                           // echo $showallsql;

                    }
                    else if($dealvalue==102)
                    {
                        if($companysearch!="")
                        {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1. " and pec.companyname LIKE '%$companysearch%' $comp_industry_id_where
                                    ORDER BY pec.companyname";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> Investor search- ".$showallsql;
                        }
                        else if($keyword!="")
                        {
                             $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r, ipo_investors AS peinv, peinvestors AS inv
                                    WHERE pec.PECompanyId = pe.PEcompanyId
                                    AND peinv.IPOId = pe.IPOId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1. " and Investor like '%$keyword%' $comp_industry_id_where
                                    ORDER BY pec.companyname";

                            $totalallsql = $exportsql =$showallsql;
                            // echo "<br> sector search- ".$showallsql;
                        }
                        elseif($sectorsearch!="")
                        {
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1. " and pec.sector_business LIKE '%$sectorsearch%' $comp_industry_id_where
                                    ORDER BY pec.companyname";

                            $totalallsql = $exportsql =$showallsql;
                            // echo "<br> sector search- ".$showallsql;
                        }else if($searchallfield !=''){
                            
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1. " and ( i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                    OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%') $search
                                    ORDER BY pec.companyname";

                                    $totalallsql = $exportsql =$showallsql;
                        }
                        elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                               
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                     $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1. " and ($tagsval) $search
                                    ORDER BY pec.companyname";

                                    $totalallsql = $exportsql =$showallsql;
    }

                        else
                        {
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                  FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                  WHERE ";

                            if ($industry > 0)
                                $whereind = " pec.industry=" .$industry ;

                            if ($investorType!= "")
                                $whereInvType = " pe.InvestorType = '".$investorType."'";

                            if($city != "")
                            {
                                $whereCity=" pec.city LIKE '".$city."'";
                            }

                            if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                            {
                                $startRangeValue=$startRangeValue;
                                $endRangeValue=$endRangeValue-0.01;
                                $qryRangeTitle="Deal Range (M$) - ";
                                if($startRangeValue < $endRangeValue)
                                {
                                        $whererange = " pe.IPOAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                }
                                elseif($startRangeValue = $endRangeValue)
                                {
                                        $whererange = " pe.IPOAmount >= ".$startRangeValue ."";
                                }
                            }

                            if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                            }

                            if(($wheredates != "") )
                            {
                                     $showallsql = $showallsql . $wheredates ." and ";
                                     $bool=true;
                            }

                            if ($whereind != "")
                            {
                                    $showallsql=$showallsql . $whereind ." and ";

                                    $bool=true;
                            }
                            else
                            {
                                    $bool=false;
                            }
                            if (($wherestage != ""))
                            {
                                    $showallsql=$showallsql. $wherestage . " and " ;
                                    $bool=true;
                            }
                            if($whereRound !="")
                            {
                                $showallsql=$showallsql . $whereRound . " and " ;
                            }      
                            if (($whereInvType != "") )
                            {
                                    $showallsql=$showallsql.$whereInvType . " and ";
                                    $bool=true;
                            }
                            if (($whererange != "") )
                            {
                                    $showallsql=$showallsql.$whererange . " and ";
                                    $bool=true;
                            }
                            if($whereCity !="")
                            {
                                $showallsql=$showallsql.$whereCity." and ";
                            }
                            $totalallsql = $exportsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId 
                                  AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                  AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall.$comp_industry_id_where." 
                                  ORDER BY pec.companyname";

                            $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId 
                                  AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                  AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall.$comp_industry_id_where." 
                                  ORDER BY pec.companyname";
                            //echo $showallsql;
                        }

                     }
                }
                else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11 || $vcflagValue==12)
                {
                     if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates1 = " and DealDate between '" . $dt1. "' and '" . $dt2 . "' ";
                           }
                     
                    $dealtype=' , dealtypes as dt '; 
                   
                    if($dealvalue==101)
                    {
                         if($vcflagValue==9 || $vcflagValue==12) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                            else if($vcflagValue==10 || $vcflagValue==11) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }

                        if($keyword!="")
                        {
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1." and Investor like '%$keyword%'   ".$dealcond." $comp_industry_id_where order by inv.Investor";

                            $totalallsql = $exportsql =$showallsql;
                        }
                        elseif($companysearch!="")
                        {
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv   ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and pec.companyname like '%$companysearch%'   ".$dealcond." $comp_industry_id_where order by inv.Investor";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> company search- ".$showallsql;
                        }
                        elseif($sectorsearch!="")
                        {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype." 
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1. " and pec.sector_business like '%$sectorsearch%'   ".$dealcond." $comp_industry_id_where order by inv.Investor";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> sector search- ".$showallsql;
                        }
                        elseif($advisorsearch_legal!="")
                        {
                                $showallsql="(SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'".$wheredates1."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)
                                     UNION(SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'".$wheredates1."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br>advisor_legal search- ".$showallsql;
                        }
                        elseif($advisorsearch_trans!="")
                        {
                                $showallsql="(SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'".$wheredates1."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)
                                     UNION(SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'".$wheredates1."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> $advisor_trans search- ".$showallsql;
                        }
                            elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                               
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, country as c   ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            and  inv.countryid= c.countryid 
                            AND pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) ".$wheredates1."  ".$dealcond."  order by inv.Investor";

                                $totalallsql = $exportsql=$showallsql;
                    }
                        elseif($searchallfield!="")
                        {
                            $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, country as c   ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            and  inv.countryid= c.countryid 
                            AND pe.Deleted=0 " .$addVCFlagqry. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%' ) ".$wheredates1."  ".$dealcond."  order by inv.Investor";

                                $totalallsql = $exportsql=$showallsql;
                            //echo "<br> company search- ".$showallsql;

                        }
                        else
                        {
                          $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor
                                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv   ".$dealtype." WHERE ";

                            //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0)
                                    $whereind = " pec.industry=" .$industry ;

                            if ($investorType!= "")
                                    $whereInvType = " pe.InvestorType = '".$investorType."'";

                            if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                    $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                                
                                    if (count($countryNINtxt) > 0 && $country_value_check == 1)//T-966 changes
                                    {
                                        if($countryNINtxt[0] == 'All'){//T-966 changes
                                            $wherecountryNIN = " inv.countryid != 'IN'" ;
                                        } else {
                                            $wherecountryNIN = " inv.countryid IN (".$countryid_code.")" ;
                                        }
                                    }
                                
                            if (count($cityname_list) && $cityid[0] != "--")
                            $wherecitytxt = " inv.City IN (".$cityname_list.")";

                            if ($firmtypetxt!= "" && $firmtypetxt != "--")
                                    $wherefirmtypetxt = " inv.FirmTypeId IN (".$firmtypevalue.")";

                            if($city != "")
                            {
                                   $whereCity=" pec.city LIKE '".$city."'";
                            }
                            

                           if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                           {
                                   $startRangeValue=$startRangeValue;
                                   $endRangeValue=$endRangeValue-0.01;
                                   $qryRangeTitle="Deal Range (M$) - ";
                                   if($startRangeValue < $endRangeValue)
                                   {
                                           $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                   }
                                   elseif($startRangeValue = $endRangeValue)
                                   {
                                           $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                   }
                           }

                           if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                           }

                           if(($wheredates != "") )
                           {
                                    $showallsql = $showallsql . $wheredates ." and ";
                                    $bool=true;
                           }

                            if ($whereind != "")
                            {
                                    $showallsql=$showallsql . $whereind ." and ";

                                    $bool=true;
                            }
                            else
                            {
                                    $bool=false;
                            }

                              if ($wherecountry != "")
                             {
                                     $showallsql=$showallsql . $wherecountry ." and ";
                                     $bool=true;
                             }
                             if ($wherecountryNIN != "")
                             {
                                     $showallsql=$showallsql . $wherecountryNIN ." and ";
                                     $bool=true;
                             }
                             if ($wherecitytxt != "")
                             {
                                     $showallsql=$showallsql . $wherecitytxt ." and ";
                                     $bool=true;
                             }

                            if (($whereInvType != "") )
                            {
                                    $showallsql=$showallsql.$whereInvType . " and ";
                                    $bool=true;
                            }
                            if (($wherefirmtypetxt != "") )
                            {
                                    $showallsql=$showallsql.$wherefirmtypetxt . " and ";
                                    $bool=true;
                            }
                            if (($whererange != "") )
                            {
                                    $showallsql=$showallsql.$whererange . " and ";
                                    $bool=true;
                            }
                            if($whereCity !="")
                            {
                                $showallsql=$showallsql.$whereCity." and ";
                            }

                            $totalallsql = $exportsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
                                                    AND pec.industry !=15
                                                    AND peinv.MandAId = pe.MandAId
                                                    AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " ".$dirsearchall."    ".$dealcond.$comp_industry_id_where."  order by inv.Investor ";  

                            $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
                                                    AND pec.industry !=15
                                                    AND peinv.MandAId = pe.MandAId
                                                    AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " " .$search." ".$dirsearchall."    ".$dealcond.$comp_industry_id_where."  order by inv.Investor ";  


                            // echo $showallsql;
                            // exit();
                        }
                    }
                    else if($dealvalue==111)
                    {
                         if($vcflagValue==9 || $vcflagValue==12) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                            else if($vcflagValue==10 || $vcflagValue==11) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }
                            if($keyworddir!="")
                            {
                               /*$showallsql="select distinct lp.*
                               from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i,limited_partners as lp
                               where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                               pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and
                               pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1" .$addVCFlagqry. " and inv.Investor like '%$keyword%' $comp_industry_id_where  GROUP BY lp.LPId order by lp.InstitutionName ";*/
                               $showallsql="select distinct lp.* FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv,limited_partners as lp  ".$dealtype." 
                               WHERE pe.PECompanyId = pec.PEcompanyId
                               AND pec.industry !=15
                               AND peinv.MandAId = pe.MandAId
                               AND inv.InvestorId = peinv.InvestorId
                               AND pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, trim(REPLACE( inv.LimitedPartners,', ',','))) and lp.Deleted!=1" .$addVCFlagqry. " and inv.Investor like '%$keyworddir%' ".$dealcond." $comp_industry_id_where   GROUP BY lp.LPId order by lp.InstitutionName ";
   
                               $totalallsql=$exportsql=$showallsql;
                                //echo "<br> Investor search 0 or 1- ".$showallsql;
                            }
                       
                        elseif($searchallfield!="")
                        {
                            $showallsql="SELECT DISTINCT lp.*
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, country as c  ,limited_partners as lp ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            and  inv.countryid= c.countryid 
                            AND pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1" .$addVCFlagqry. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%' ) "."  ".$dealcond."  GROUP BY lp.LPId order by lp.InstitutionName";

                                $totalallsql = $exportsql=$showallsql;
                            //echo "<br> company search- ".$showallsql;

                        }
                         else
                         {
                            if($vcflagValue==1)
                            {
                                $joinvctable=" ,peinvestments as pe   ";
                                $vccondition=" and pe.amount<=20 ";
                            }else{
                                $joinvctable="";
                                $vccondition="";
                            }

                            // $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                            //  where    inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                            //  ";
                            
                             $showallsql = "select distinct lp.* FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv,limited_partners as lp  ".$dealtype." 
                             WHERE pe.PECompanyId = pec.PEcompanyId
                             AND pec.industry !=15
                             AND peinv.MandAId = pe.MandAId
                             AND inv.InvestorId = peinv.InvestorId
                             AND pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, trim(REPLACE( inv.LimitedPartners,', ',','))) and lp.Deleted!=1" .$addVCFlagqry .$search.$dirsearchall.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                             ";
                             $totalallsql=$exportsql=$showallsql;  

                            
                         }
                    }
                    else if($dealvalue==102)
                    {
                        if($vcflagValue==9 || $vcflagValue==12) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                        else if($vcflagValue==10 || $vcflagValue==11) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }

                        if($companysearch!="")
                        {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r ".$dealtype."
                                WHERE pec.PECompanyId = pe.PEcompanyId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1." and pec.companyname LIKE '%$companysearch%'   ".$dealcond.$comp_industry_id_where."
                                ORDER BY pec.companyname";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> Investor search- ".$showallsql;
                        }
                        elseif($keyword!="")
                        {
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, industry AS i, region AS r ".$dealtype."
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                            AND r.RegionId = pec.RegionId 
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId " .$addVCFlagqry.$wheredates1. " and Investor like '%$keyword%'   ".$dealcond.$comp_industry_id_where."  order by inv.Investor";

                            $totalallsql = $exportsql =$showallsql;
                        }
                        elseif($sectorsearch!="")
                        {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r ".$dealtype."
                                WHERE pec.PECompanyId = pe.PEcompanyId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1." and pec.sector_business LIKE '%$sectorsearch%'    ".$dealcond.$comp_industry_id_where."
                                ORDER BY pec.companyname";

                                $totalallsql = $exportsql =$showallsql;
                           // echo "<br> sector search- ".$showallsql;
                        }
                        elseif($advisorsearch_legal!="")
                        {
                                $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac,
                                industry AS i, region AS r  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'    ".$dealcond."  and AdvisorType='L'".$wheredates1."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)
                                     UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region 
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,
                                industry AS i, region AS r ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'".$wheredates1."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br>advisor_legal search- ".$showallsql;
                        }
                        elseif($advisorsearch_trans!="")
                        {
                                $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region 
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac,
                                industry AS i, region AS r ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'".$wheredates1."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)
                                     UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region ".$dealtype."
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,
                                industry AS i, region AS r ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'".$wheredates1."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)";

                                $totalallsql = $exportsql =$showallsql;
                           // echo "<br> $advisor_trans search- ".$showallsql;
                        }
                            elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                               
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r ".$dealtype."
                                WHERE pec.PECompanyId = pe.PEcompanyId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1." and ( $tagsval ) ".$dealcond."
                                $comp_industry_id_where ORDER BY pec.companyname";

                                $totalallsql = $exportsql =$showallsql;
    }
                        else if($searchallfield!="")
                        {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r ".$dealtype."
                                WHERE pec.PECompanyId = pe.PEcompanyId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates1." and ( i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                        OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%' or pec.tags like '%$searchallfield%') ".$dealcond."
                                $comp_industry_id_where ORDER BY pec.companyname";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> Investor search- ".$showallsql;
                        }
                        else
                        {
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                            FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r  ".$dealtype."
                            WHERE ";

                            //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0)
                                    $whereind = " pec.industry=" .$industry ;

                            if ($investorType!= "")
                                    $whereInvType = " pe.InvestorType = '".$investorType."'";

                            if($city != "")
                            {
                                $whereCity=" pec.city LIKE '".$city."'";
                            }

                           if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                           {
                                   $startRangeValue=$startRangeValue;
                                   $endRangeValue=$endRangeValue-0.01;
                                   $qryRangeTitle="Deal Range (M$) - ";
                                   if($startRangeValue < $endRangeValue)
                                   {
                                           $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                   }
                                   elseif($startRangeValue = $endRangeValue)
                                   {
                                           $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                   }
                           }

                           if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                           }

                           if(($wheredates != "") )
                           {
                                    $showallsql = $showallsql . $wheredates ." and ";
                                    $bool=true;
                           }

                            if ($whereind != "")
                            {
                                    $showallsql=$showallsql . $whereind ." and ";

                                    $bool=true;
                            }
                            else
                            {
                                    $bool=false;
                            }

                            if (($whereInvType != "") )
                            {
                                    $showallsql=$showallsql.$whereInvType . " and ";
                                    $bool=true;
                            }
                            if (($whererange != "") )
                            {
                                    $showallsql=$showallsql.$whererange . " and ";
                                    $bool=true;
                            }
                            if($whereCity !="")
                            {
                                $showallsql=$showallsql.$whereCity." and ";
                            }

                            $totalallsql = $exportsql = $showallsql. "  pec.PECompanyId = pe.PEcompanyId 
                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall."     ".$dealcond.$comp_industry_id_where."
                            ORDER BY pec.companyname";  

                            $showallsql = $showallsql. "  pec.PECompanyId = pe.PEcompanyId 
                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."    ".$dealcond.$comp_industry_id_where."
                            ORDER BY pec.companyname ";
                        }
                     }
                    elseif($dealvalue==104 || $dealvalue==103)
                    {
                        if($_SESSION['PE_industries']!=''){

                            $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';
                        }
                        if($vcflagValue==9 || $vcflagValue==12) { $dealcond='AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                        else if($vcflagValue==10 || $vcflagValue==11) { $dealcond='AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }

                        if($advisorsearch_trans!="")
                        {
                             $showallsql="(
                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac      ".$dealtype." 
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )
                                     UNION (
                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp   ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adcomp.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )    ORDER BY Cianame";
                            //echo "<br> Investor search- ".$showallsql;
                             $totalallsql = $exportsql =$showallsql;

                        }
                        else if($advisorsearch_legal!="")
                        {
                             $showallsql="(
                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac   ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )
                                     UNION (
                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp   ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adcomp.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )    ORDER BY Cianame";
                            //echo "<br> Investor search- ".$showallsql;
                             $totalallsql = $exportsql =$showallsql;

                        }
                        elseif($companysearch!="")
                        {
                            $showallsql="(
                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac   ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )
                                     UNION (
                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp    ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adcomp.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )    ORDER BY Cianame";

                                $totalallsql = $exportsql =$showallsql;
                           // echo "<br> Investor search- ".$totalallsql;
                        }
                        elseif($keyword!="")
                        {
                            $showallsql="(
                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c,manda_investors AS pe, peinvestors AS inv,
                                     advisor_cias AS cia, peinvestments_advisoracquirer AS adac    ".$dealtype."
                                     WHERE Deleted =0 AND pe.MandAId = peinv.MandAId
                                    AND inv.InvestorId = pe.InvestorId 
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adac.CIAId = cia.CIAID and Investor like '%$keyword%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )
                                     UNION (
                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c,manda_investors AS pe, peinvestors AS inv, 
                                     advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp ".$dealtype."
                                     WHERE Deleted =0 AND pe.MandAId = peinv.MandAId
                                    AND inv.InvestorId = pe.InvestorId 
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adcomp.CIAId = cia.CIAID and Investor like '%$keyword%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )    ORDER BY Cianame"; 

                                $totalallsql = $exportsql =$showallsql;
                             //echo "<br> Investor search- ".$showallsql;
                        }
                        elseif($sectorsearch!="")
                        {
                                $showallsql="(
                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac    ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )
                                     UNION (
                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adcomp.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%'   ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )    ORDER BY Cianame";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> sector search- ".$showallsql;
                        }
                            elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                               
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(c.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(c.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="(
                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac   ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adac.CIAId = cia.CIAID and ( $tagsval) ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )
                                     UNION (
                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adcomp.CIAId = cia.CIAID and ($tagsval) ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )    ORDER BY Cianame";

                                $totalallsql = $exportsql =$showallsql;
    }
                        elseif($searchallfield!="")
                        {
                            $showallsql="(
                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac   ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adac.CIAId = cia.CIAID and ( cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%' or c.tags like '%$searchallfield%') ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )
                                     UNION (
                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp ".$dealtype."
                                     WHERE Deleted =0
                                     AND c.PECompanyId = peinv.PECompanyId
                                     AND adcomp.CIAId = cia.CIAID and ( cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%' or c.tags like '%$searchallfield%') ".$dealcond."  and AdvisorType='".$adtype ."'".$wheredates1."
                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                     " )    ORDER BY Cianame";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> Investor search- ".$showallsql;
                        }
                        else
                        {

                            $companysql= "(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac    ".$dealtype."    WHERE c.RegionId=re.RegionId and";
                            $companysql2= "SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp  ".$dealtype."   WHERE c.RegionId=re.RegionId and";

                            //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0)
                                $whereind = " c.industry=" .$industry ;

                            if ($investorType!= "")
                                $whereInvType = " peinv.InvestorType = '".$investorType."'";

                            if($city != "")
                            {
                                $whereCity=" c.city LIKE '%".$city."%'";
                            }

                           if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                           {
                                   $startRangeValue=$startRangeValue;
                                   $endRangeValue=$endRangeValue-0.01;
                                   $qryRangeTitle="Deal Range (M$) - ";
                                   if($startRangeValue < $endRangeValue)
                                   {
                                        $whererange = " peinv.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                   }
                                   elseif($startRangeValue = $endRangeValue)
                                   {
                                        $whererange = " peinv.amount >= ".$startRangeValue ."";
                                   }
                           }

                           if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                //$wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                           }

                            if ($whereind != "")
                            {
                                $companysql=$companysql . $whereind ." and ";
                                $companysql2=$companysql2 . $whereind ." and ";
                            }

                            if ($whereInvType != "")
                            {
                                $companysql=$companysql . $whereInvType ." and ";
                                $companysql2=$companysql2 . $whereInvType ." and ";
                            }

                            if (($whererange != "") )
                            {
                                $companysql=$companysql .$whererange . " and ";
                                $companysql2=$companysql2 .$whererange . " and ";
                            }

                            // if(($wheredates != "") )
                            // {
                            //     $companysql = $companysql.$wheredates ." and ";
                            //     $companysql2 = $companysql2.$wheredates ." and ";
                            // }

                            if($whereCity !="")
                            {
                                $companysql=$companysql.$whereCity." and ";
                                $companysql2 = $companysql2.$whereCity ." and ";
                            }

                             $companysqltot = $companysql ." Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall." 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.   "$dealcond $comp_industry_id_where"  ;
                            $companysqltot2 = $companysql2 ." Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."' ".$dirsearchall." 
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.  "$dealcond $comp_industry_id_where"  ;

                            $companysql = $companysql ." Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.  "$dealcond $comp_industry_id_where"  ;
                            $companysql2 = $companysql2 ." Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.  "$dealcond $comp_industry_id_where"  ;



                            $showallsql=$companysql.") UNION (".$companysql2.") ";
                            $totalallsql=$companysqltot.") UNION (".$companysqltot2.") ";

                            $orderby="order by Cianame"; 
                            $showallsql=$showallsql.$orderby;
                            $totalallsql=$totalallsql.$orderby;
                            $exportsql = $totalallsql;
                        //echo $showallsql;

                        }

                     }
                    
                }
              
    $topNav = 'Directory';
        $defpage=$defvalue;
        $stagedef=1;
        $tour='Allow';
        echo "<div style='display:none'>$showallsql</div>";
        //echo 'flag='.$vcflagValue; exit;
        $strvalue[1]='';
    include_once('dirnew_header.php');
?>
    <style>
    .page-dir .result-title.resettag{
    height: 200px;
   }
.page-dir .result-select.resettaglist{
    overflow-y: scroll;
    height: 145px;
}
    .result-title{width:95%;}
        .ui-multiselect-hasfilter .ui-helper-reset {
    display: block !important;
}
.ui-multiselect-filter input {
    width: 220px !important;
}
    .filter-area .select2-container--default .select2-selection--multiple .select2-selection__rendered{
        padding: 0px 0px 3px 3px;
    }
    .filter-area .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
        margin-right: 5px;
    }
    
     @keyframes blinker {
  50% { opacity: 0.0; }
}
.blinktext{animation: blinker 2s linear infinite;}
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
        .selectgroup.citysearch button{
            width: 250px !important;
            height: 28px !important;
        }
        .selectgroup.countryNIN button{
            width: 250px !important;
            height: 28px !important;
        }
    </style>
<style>

/*LP */
/*.lpalign{
    white-space: nowrap;
    overflow: hidden;
}*/
.result-select-close a {
    margin: -8px -1px 0px 0px !important;
}
.result-title li{
    margin: 0px 0px 4px 2px !important;
}
.page-dir .result-select {
    padding: 3px 6px 0px 0px !important;
}

.title-links a#expshowdeals, .title-links a#expshowdealsbtn{
    margin-top: 0px;margin-left: 0px;
}
.exportinvest{
    border: 1px solid #a2733a;
}
.separator{
    display: inline-block;font-size: 20px;margin-right: -6px;vertical-align: middle;color: #624C34;margin-top: -18px;padding: 0px 8px;
}
.investor-title{
    margin-top: -22px;
    padding-left: 10px;
    margin-bottom: 5px;
}
.select2-selection.select2-selection--multiple{
    border-radius: 0px !important;
    border: 1px solid #a2753a !important;
    color: #444 !important;
    line-height: 28px !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 0px !important;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 3px !important;
    padding: 0 5px;
}
.select2-selection.select2-selection--multiple {
    border-radius: 0px !important;
    border: 1px solid #a2753a !important;
    color: #444 !important;
    line-height: 22px !important;
}
.city_country_filter_btn{
    display:none;
}
.with-invs{
    font-size: 13px;
    padding: 5px;
    border-bottom: 1px solid #a37535;
    background-color: #fff;
    text-align: center;
    padding-top: 30px;
    cursor: pointer;
}
.without-invs{
    font-size: 13px;
    padding: 5px;
    background-color: #fff;
    text-align: center;
    cursor: pointer;
}
.search-box input[type="button"], .search-box input[type="submit"] {
    cursor: pointer;
    float: left;
    background: url(../dealsnew/images/icon-search.png) no-repeat center #a2753a;
    border: 1px solid #a2753a;
    width: 33px;
    height: 25px;
}
.filter-area {
    float: left;
    margin-left: 20px;
    margin-top: -18px;
}
.filter-area select {
    margin-right:15px;
}
.clearfix {
    clear:both;
}
.filter-area .select2-container{
vertical-align: top !important;
}
.select2-container{box-sizing:border-box;display:inline-block;margin:0;position:relative;vertical-align:middle}.select2-container .select2-selection--single{box-sizing:border-box;cursor:pointer;display:block;height:28px;user-select:none;-webkit-user-select:none}.select2-container .select2-selection--single .select2-selection__rendered{display:block;padding-left:8px;padding-right:20px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.select2-container .select2-selection--single .select2-selection__clear{position:relative}.select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered{padding-right:8px;padding-left:20px}.select2-container .select2-selection--multiple{box-sizing:border-box;cursor:pointer;display:block;min-height:32px;user-select:none;-webkit-user-select:none}.select2-container .select2-selection--multiple .select2-selection__rendered{display:inline-block;overflow:hidden;padding-left:8px;text-overflow:ellipsis;white-space:nowrap}.select2-container .select2-search--inline{float:left}.select2-container .select2-search--inline .select2-search__field{box-sizing:border-box;border:none;font-size:100%;margin-top:5px;padding:0}.select2-container .select2-search--inline .select2-search__field::-webkit-search-cancel-button{-webkit-appearance:none}.select2-dropdown{background-color:white;border:1px solid #aaa;border-radius:4px;box-sizing:border-box;display:block;position:absolute;left:-100000px;width:100%;z-index:1051}.select2-results{display:block}.select2-results__options{list-style:none;margin:0;padding:0}.select2-results__option{padding:6px;user-select:none;-webkit-user-select:none}.select2-results__option[aria-selected]{cursor:pointer}.select2-container--open .select2-dropdown{left:0}.select2-container--open .select2-dropdown--above{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--open .select2-dropdown--below{border-top:none;border-top-left-radius:0;border-top-right-radius:0}.select2-search--dropdown{display:block;padding:4px}.select2-search--dropdown .select2-search__field{padding:4px;width:100%;box-sizing:border-box}.select2-search--dropdown .select2-search__field::-webkit-search-cancel-button{-webkit-appearance:none}.select2-search--dropdown.select2-search--hide{display:none}.select2-close-mask{border:0;margin:0;padding:0;display:block;position:fixed;left:0;top:0;min-height:100%;min-width:100%;height:auto;width:auto;opacity:0;z-index:99;background-color:#fff;filter:alpha(opacity=0)}.select2-hidden-accessible{border:0 !important;clip:rect(0 0 0 0) !important;-webkit-clip-path:inset(50%) !important;clip-path:inset(50%) !important;height:1px !important;overflow:hidden !important;padding:0 !important;position:absolute !important;width:1px !important;white-space:nowrap !important}.select2-container--default .select2-selection--single{background-color:#fff;border:1px solid #aaa;border-radius:4px}.select2-container--default .select2-selection--single .select2-selection__rendered{color:#444;line-height:28px}.select2-container--default .select2-selection--single .select2-selection__clear{cursor:pointer;float:right;font-weight:bold}.select2-container--default .select2-selection--single .select2-selection__placeholder{color:#999}.select2-container--default .select2-selection--single .select2-selection__arrow{height:26px;position:absolute;top:1px;right:1px;width:20px}.select2-container--default .select2-selection--single .select2-selection__arrow b{border-color:#888 transparent transparent transparent;border-style:solid;border-width:5px 4px 0 4px;height:0;left:50%;margin-left:-4px;margin-top:-2px;position:absolute;top:50%;width:0}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__clear{float:left}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow{left:1px;right:auto}.select2-container--default.select2-container--disabled .select2-selection--single{background-color:#eee;cursor:default}.select2-container--default.select2-container--disabled .select2-selection--single .select2-selection__clear{display:none}.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{border-color:transparent transparent #888 transparent;border-width:0 4px 5px 4px}.select2-container--default .select2-selection--multiple{background-color:white;border:1px solid #aaa;border-radius:4px;cursor:text}.select2-container--default .select2-selection--multiple .select2-selection__rendered{box-sizing:border-box;list-style:none;margin:0;padding:0 5px;width:100%}.select2-container--default .select2-selection--multiple .select2-selection__rendered li{list-style:none}.select2-container--default .select2-selection--multiple .select2-selection__placeholder{color:#999;margin-top:5px;float:left}.select2-container--default .select2-selection--multiple .select2-selection__clear{cursor:pointer;float:right;font-weight:bold;margin-top:5px;margin-right:10px}.select2-container--default .select2-selection--multiple .select2-selection__choice{background-color:#e4e4e4;border:1px solid #aaa;border-radius:4px;cursor:default;float:left;margin-right:5px;margin-top:5px;padding:0 5px}.select2-container--default .select2-selection--multiple .select2-selection__choice__remove{color:#999;cursor:pointer;display:inline-block;font-weight:bold;margin-right:2px}.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover{color:#333}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice,.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__placeholder,.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-search--inline{float:right}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice{margin-left:5px;margin-right:auto}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove{margin-left:2px;margin-right:auto}.select2-container--default.select2-container--focus .select2-selection--multiple{border:solid black 1px;outline:0}.select2-container--default.select2-container--disabled .select2-selection--multiple{background-color:#eee;cursor:default}.select2-container--default.select2-container--disabled .select2-selection__choice__remove{display:none}.select2-container--default.select2-container--open.select2-container--above .select2-selection--single,.select2-container--default.select2-container--open.select2-container--above .select2-selection--multiple{border-top-left-radius:0;border-top-right-radius:0}.select2-container--default.select2-container--open.select2-container--below .select2-selection--single,.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple{border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--default .select2-search--dropdown .select2-search__field{border:1px solid #aaa}.select2-container--default .select2-search--inline .select2-search__field{background:transparent;border:none;outline:0;box-shadow:none;-webkit-appearance:textfield}.select2-container--default .select2-results>.select2-results__options{max-height:200px;overflow-y:auto}.select2-container--default .select2-results__option[role=group]{padding:0}.select2-container--default .select2-results__option[aria-disabled=true]{color:#999}.select2-container--default .select2-results__option[aria-selected=true]{background-color:#ddd}.select2-container--default .select2-results__option .select2-results__option{padding-left:1em}.select2-container--default .select2-results__option .select2-results__option .select2-results__group{padding-left:0}.select2-container--default .select2-results__option .select2-results__option .select2-results__option{margin-left:-1em;padding-left:2em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-2em;padding-left:3em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-3em;padding-left:4em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-4em;padding-left:5em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-5em;padding-left:6em}.select2-container--default .select2-results__option--highlighted[aria-selected]{background-color:#5897fb;color:white}.select2-container--default .select2-results__group{cursor:default;display:block;padding:6px}.select2-container--classic .select2-selection--single{background-color:#f7f7f7;border:1px solid #aaa;border-radius:4px;outline:0;background-image:-webkit-linear-gradient(top, #fff 50%, #eee 100%);background-image:-o-linear-gradient(top, #fff 50%, #eee 100%);background-image:linear-gradient(to bottom, #fff 50%, #eee 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFFFF', endColorstr='#FFEEEEEE', GradientType=0)}.select2-container--classic .select2-selection--single:focus{border:1px solid #5897fb}.select2-container--classic .select2-selection--single .select2-selection__rendered{color:#444;line-height:28px}.select2-container--classic .select2-selection--single .select2-selection__clear{cursor:pointer;float:right;font-weight:bold;margin-right:10px}.select2-container--classic .select2-selection--single .select2-selection__placeholder{color:#999}.select2-container--classic .select2-selection--single .select2-selection__arrow{background-color:#ddd;border:none;border-left:1px solid #aaa;border-top-right-radius:4px;border-bottom-right-radius:4px;height:26px;position:absolute;top:1px;right:1px;width:20px;background-image:-webkit-linear-gradient(top, #eee 50%, #ccc 100%);background-image:-o-linear-gradient(top, #eee 50%, #ccc 100%);background-image:linear-gradient(to bottom, #eee 50%, #ccc 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFCCCCCC', GradientType=0)}.select2-container--classic .select2-selection--single .select2-selection__arrow b{border-color:#888 transparent transparent transparent;border-style:solid;border-width:5px 4px 0 4px;height:0;left:50%;margin-left:-4px;margin-top:-2px;position:absolute;top:50%;width:0}.select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__clear{float:left}.select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__arrow{border:none;border-right:1px solid #aaa;border-radius:0;border-top-left-radius:4px;border-bottom-left-radius:4px;left:1px;right:auto}.select2-container--classic.select2-container--open .select2-selection--single{border:1px solid #5897fb}.select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow{background:transparent;border:none}.select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b{border-color:transparent transparent #888 transparent;border-width:0 4px 5px 4px}.select2-container--classic.select2-container--open.select2-container--above .select2-selection--single{border-top:none;border-top-left-radius:0;border-top-right-radius:0;background-image:-webkit-linear-gradient(top, #fff 0%, #eee 50%);background-image:-o-linear-gradient(top, #fff 0%, #eee 50%);background-image:linear-gradient(to bottom, #fff 0%, #eee 50%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFFFF', endColorstr='#FFEEEEEE', GradientType=0)}.select2-container--classic.select2-container--open.select2-container--below .select2-selection--single{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0;background-image:-webkit-linear-gradient(top, #eee 50%, #fff 100%);background-image:-o-linear-gradient(top, #eee 50%, #fff 100%);background-image:linear-gradient(to bottom, #eee 50%, #fff 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFFFFFFF', GradientType=0)}.select2-container--classic .select2-selection--multiple{background-color:white;border:1px solid #aaa;border-radius:4px;cursor:text;outline:0}.select2-container--classic .select2-selection--multiple:focus{border:1px solid #5897fb}.select2-container--classic .select2-selection--multiple .select2-selection__rendered{list-style:none;margin:0;padding:0 5px}.select2-container--classic .select2-selection--multiple .select2-selection__clear{display:none}.select2-container--classic .select2-selection--multiple .select2-selection__choice{background-color:#e4e4e4;border:1px solid #aaa;border-radius:4px;cursor:default;float:left;margin-right:5px;margin-top:5px;padding:0 5px}.select2-container--classic .select2-selection--multiple .select2-selection__choice__remove{color:#888;cursor:pointer;display:inline-block;font-weight:bold;margin-right:2px}.select2-container--classic .select2-selection--multiple .select2-selection__choice__remove:hover{color:#555}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice{float:right}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice{margin-left:5px;margin-right:auto}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove{margin-left:2px;margin-right:auto}.select2-container--classic.select2-container--open .select2-selection--multiple{border:1px solid #5897fb}.select2-container--classic.select2-container--open.select2-container--above .select2-selection--multiple{border-top:none;border-top-left-radius:0;border-top-right-radius:0}.select2-container--classic.select2-container--open.select2-container--below .select2-selection--multiple{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--classic .select2-search--dropdown .select2-search__field{border:1px solid #aaa;outline:0}.select2-container--classic .select2-search--inline .select2-search__field{outline:0;box-shadow:none}.select2-container--classic .select2-dropdown{background-color:#fff;border:1px solid transparent}.select2-container--classic .select2-dropdown--above{border-bottom:none}.select2-container--classic .select2-dropdown--below{border-top:none}.select2-container--classic .select2-results>.select2-results__options{max-height:200px;overflow-y:auto}.select2-container--classic .select2-results__option[role=group]{padding:0}.select2-container--classic .select2-results__option[aria-disabled=true]{color:grey}.select2-container--classic .select2-results__option--highlighted[aria-selected]{background-color:#3875d7;color:#fff}.select2-container--classic .select2-results__group{cursor:default;display:block;padding:6px}.select2-container--classic.select2-container--open .select2-dropdown{border-color:#5897fb}
<?php if($dealvalue == 101) { ?>
    .select2-container {
        width: 290px !important;
        font-size: 14px;
        color: black;
        margin-right: 17px;
    }
<?php } else { ?>
    .select2-container {
        width: 224px; !important;
        font-size: 14px;
        color: black;
        margin-right: 17px;
    }
<?php }?>

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
#city_div{
    float: right !important;
    margin: 0px 5px;
}
#country_div{
    float: right !important;
    margin: 0px 5px;
}
@media (max-width: 1400px){
    .select2-container:nth-of-type(2){
        width: 145px !important;
    }
    .select2-container:nth-of-type(3){
        width: 145px !important;
    }
}
@media (max-width: 1024px){
    .tab-view-btn {
        margin-top: 10px !important;
        margin-bottom: -20px;
    }
}
@media (max-width: 768px){
    .select2-container {
        width: 174px !important;margin-right: 0px;
    }
    .select2-container:nth-of-type(2){
        width: 174px !important;
    }
    .select2-container:nth-of-type(3){
        width: 174px !important;
    }
}
@media (max-width: 1400px){
    .selectgroup.citysearch button,.selectgroup.countryNIN button{
width: 145px !important;
}
.ui-multiselect-filter input{
    width: 100px !important;
}

}
@media (min-width: 1025px) and (max-width: 1281px) {
    .select2-container {
        width: 235px !important;
    }
    .selectgroup.citysearch button,.selectgroup.countryNIN button{
width: 180px !important;
}
.ui-multiselect-filter input{
    width: 149px !important;
}
}


</style>
<!-- <script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.filter.css" />
<script type="text/javascript" src="js/jquery.multiselect.filter.js"></script> -->

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" style="margin-top: -17px;">
<tr>
<?php if( $vcflagValue !=6 && $dealvalue!=110 )
{
    ?>

<td class="left-td-bg" id="tdfilter" <?php if($dealvalue==111){echo "style=display:none;";}?>>
    <div class="acc_main" id="acc_main" style="margin-top:15px;">
        <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active" id="openRefine">Slide Panel</a></div>    
        <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php 

if($vcflagValue!=2 && $dealvalue!=111){
   
    include_once('newdirrefine1.php');
}elseif($vcflagValue == 2 && $dealvalue!=110 && $dealvalue!=111){

    include_once('dirangelrefine.php');
}
?> <input type="hidden" name='cityflag' id="cityflag" value="<?php echo $_POST['cityflag'];?>"/>
<input type="hidden" name='countryNINflag' id="countryNINflag" value="<?php echo $_POST['countryNINflag'];?>"/>

     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
    </div>  
</div>

</td>
 <?php
}
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
            
                            $totalDisplay="Total";
                            $industryAdded ="";
                            $totalAmount=0.0;
                            $totalInv=0;
                            $compDisplayOboldTag="";
                            $compDisplayEboldTag="";
                            
                            if ($rsinvestortot = mysql_query($totalallsql))
                            {
                                 $investor_cnt = mysql_num_rows($rsinvestortot);
                            }
                            
                            if($investor_cnt > 0 || $dealvalue==110 ||  $dealvalue==111)
                            {
                                         //$searchTitle=" List of Deals";
                                if($searchallfield!=''){
                                    
                                    $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                    $search_date=date('Y-m-d');
                                    $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('".$_SESSION['UserEmail']."','".$_SESSION['UserNames']."','".$searchallfield."',1,1,0,'".$search_date."','".$search_link."')";
                                    mysql_query($search_query);
                                }
                            }
                            else
                            {
                                if($searchallfield!=''){
                                
                                    $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                    $search_date=date('Y-m-d');
                                    $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('".$_SESSION['UserEmail']."','".$_SESSION['UserNames']."','".$searchallfield."',0,1,0,'".$search_date."','".$search_link."')";
                                    mysql_query($search_query);
                                }
                                $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                                $notable=true;
                                writeSql_for_no_records($companysql,$emailid);
                            }
                            $rsinvestor = mysql_query($showallsql);
                            

                   ?>
<td class="profile-view-left" style="width:100%;">
<div class="result-cnt dir_header">
<?php if ($accesserror==1 && ($_SESSION['VCdircheckflag']==1 )){?>
            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
        <?php
        exit; 
        } 
        ?>  

        <div style="right: 160px;top: 99px;margin-bottom: 20px;position: fixed;z-index: 100;">
             <?php  if($dealvalue!=111) {?>
                                    <label style="font-size: 13px;font-weight: 600;margin: 0px 5px;">From</label>
                                    <SELECT NAME=month1 id="tour_month1" style="font-family: Arial;color: #004646;font-size: 13px;padding: 3px;">
             <OPTION id=1 value="--" selected> Month </option>
             <OPTION VALUE=1 <?php echo ($_POST['month1']=='1') ? 'Selected' : ''; ?>>Jan </OPTION>
             <OPTION VALUE=2 <?php echo ($_POST['month1']=='2') ? 'Selected' : ''; ?>>Feb</OPTION>
             <OPTION VALUE=3 <?php echo ($_POST['month1']=='3') ? 'Selected' : ''; ?>>Mar</OPTION>
             <OPTION VALUE=4 <?php echo ($_POST['month1']=='4') ? 'Selected' : ''; ?>>Apr</OPTION>
             <OPTION VALUE=5 <?php echo ($_POST['month1']=='5') ? 'Selected' : ''; ?>>May</OPTION>
             <OPTION VALUE=6 <?php echo ($_POST['month1']=='6') ? 'Selected' : ''; ?>>Jun</OPTION>
             <OPTION VALUE=7 <?php echo ($_POST['month1']=='7') ? 'Selected' : ''; ?>>Jul</OPTION>
             <OPTION VALUE=8 <?php echo ($_POST['month1']=='8') ? 'Selected' : ''; ?>>Aug</OPTION>
             <OPTION VALUE=9 <?php echo ($_POST['month1']=='9') ? 'Selected' : ''; ?>>Sep</OPTION>
             <OPTION VALUE=10 <?php echo ($_POST['month1']=='10') ? 'Selected' : ''; ?>>Oct</OPTION>
             <OPTION VALUE=11 <?php echo ($_POST['month1']=='11') ? 'Selected' : ''; ?>>Nov</OPTION>
            <OPTION VALUE=12 <?php echo ($_POST['month1']=='12') ? 'Selected' : ''; ?>>Dec</OPTION>
            </SELECT>

                <SELECT NAME=year1 id="tour_year1" style="font-family: Arial;color: #004646;font-size: 13px;padding: 3px;">
                <OPTION id=2 value="--" > Year </option>
                <?php
                                $currentyear = date("Y");
                $i=1998;
                While($i<= $currentyear )
                {
                                    $id = $currentyear;
                                    $name = $currentyear;
                                    if ($_POST['year1'])
                                        $selected = ($_POST['year1']==$currentyear) ? 1 : 0;

                                    if ($selected)
                                    {
                                            echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
                                    }
                                    else
                                    {
                                            echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
                                    }
                                    $currentyear--;
                }
                ?> </SELECT>
                 <label style="font-size: 13px;font-weight: 600;margin: 0px 5px;">To</label>
            <SELECT NAME=month2 id="tour_month2" style="font-family: Arial;color: #004646;font-size: 13px;padding: 3px;">
             <OPTION id=3 value="--" selected> Month </option>
             <OPTION VALUE=1 <?php echo ($_POST['month2']=='1') ? 'Selected' : ''; ?>>Jan</OPTION>
             <OPTION VALUE=2 <?php echo ($_POST['month2']=='2') ? 'Selected' : ''; ?>>Feb</OPTION>
             <OPTION VALUE=3 <?php echo ($_POST['month2']=='3') ? 'Selected' : ''; ?>>Mar</OPTION>
             <OPTION VALUE=4 <?php echo ($_POST['month2']=='4') ? 'Selected' : ''; ?>>Apr</OPTION>
             <OPTION VALUE=5 <?php echo ($_POST['month2']=='5') ? 'Selected' : ''; ?>>May</OPTION>
             <OPTION VALUE=6 <?php echo ($_POST['month2']=='6') ? 'Selected' : ''; ?>>Jun</OPTION>
             <OPTION VALUE=7 <?php echo ($_POST['month2']=='7') ? 'Selected' : ''; ?>>Jul</OPTION>
             <OPTION VALUE=8 <?php echo ($_POST['month2']=='8') ? 'Selected' : ''; ?>>Aug</OPTION>
             <OPTION VALUE=9 <?php echo ($_POST['month2']=='9') ? 'Selected' : ''; ?>>Sep</OPTION>
             <OPTION VALUE=10 <?php echo ($_POST['month2']=='10') ? 'Selected' : ''; ?>>Oct</OPTION>
             <OPTION VALUE=11 <?php echo ($_POST['month2']=='11') ? 'Selected' : ''; ?>>Nov</OPTION>
             <OPTION VALUE=12 <?php echo ($_POST['month2']=='12') ? 'Selected' : ''; ?>>Dec</OPTION>
            </SELECT>
            <SELECT name=year2 id="tour_year2" style="font-family: Arial;color: #004646;font-size: 13px;padding: 3px;" >
            <OPTION id=4 value="--" > Year </option>

            <?php
                        $currentyear2 = date("Y");
            $endYear=1998;
            While($endYear<= $currentyear2 )
            {
                $ids=$currentyear2;
                                if ($_POST['year2'])
                                    $selected = ($_POST['year2']==$currentyear2) ? 1 : 0;
                                

                                if ($selected)
                {
                    echo "<OPTION id='". $currentyear2. "' value=". $currentyear2." selected>".$currentyear2."</OPTION>\n";
                }
                else
                {
                    echo "<OPTION id='". $currentyear2. "' value=". $currentyear2." >".$currentyear2."</OPTION>\n";
                }

            $currentyear2--;
            }
            ?> 
                        </SELECT>


                        <div class="search-box" style="float: right;margin-left: 5px;">
                            <input type="button" id="searchsub" name="fliter_dir" value="" ><br>
                        </div>
 <?php  }?>
                                    </div> 

                <div class="result-title" style="margin-top:-3px;"> 
    
                                            
                            <?php if(!$_POST){
                                    ?>
                                      
                                  <?php  if($vcflagValue==0)
                                   {
                                     ?>    <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                           <?php
                                            if($dealvalue==101)
                                          {
                                           ?>
                                               <span class="result-for">for PE Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for PE-backed Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for PE Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for PE Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>  
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                           </h2>
    
                              <?php }
                                    else if($vcflagValue==1)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                            if($dealvalue==101)
                                          {
                                           ?>
                                               <span class="result-for">for VC Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for VC Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for VC Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for VC Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                                else if($vcflagValue==2)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                           
                                        <?php
                                       if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Angel Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for  Funded Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==110)
                                          {
                                      ?>
                                              <span class="result-for">for  Fundraising Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Angel Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Angel Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==3)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Social Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Social Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Social Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Social Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==4)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                              <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Cleantech Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <!--span class="result-for">for Cleantech Directory</span-->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==5)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                    <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Infrastructure Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <!-- <span class="result-for">for Infrastructure Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==6)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                    <?php
                                    if($dealvalue==105)
                                     {
                                      ?>
                                               <span class="result-for">for Incubators</span>
                                      <?php
                                          }
                                          else if($dealvalue==106)
                                          {
                                      ?>
                                              <span class="result-for">for Incubation Incubatee</span>
                                      <?php
                                          }
                                          ?>
                                            <!-- <span class="result-for">for Infrastructure Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                               else if($vcflagValue==7)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for IPO(PE) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                           <!-- <span class="result-for">for IPO(PE) Directory</span>  -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==8)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                               <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for IPO(VC) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                          <!--  <span class="result-for">for IPO(VC) Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==9)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                               <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for PMS Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                           <!-- <span class="result-for">for PMS Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==10)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                               <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for M&A(PE) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                           <!--  <span class="result-for">for M&A(PE) Directory</span>-->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==11 )
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                               <?php
                                    if($dealvalue==101 && $vcflagValue==11)
                                     {
                                      ?>
                                               <span class="result-for">for M&A(VC) Investors</span>
                                      <?php
                                          }
                                     else if($dealvalue==101 && $vcflagValue==12)
                                     {
                                      ?>
                                               <span class="result-for">for VC PMS Investors</span>
                                      <?php
                                          }    
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                           <!--  <span class="result-for">for M&A(VC) Directory</span>-->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              else if($vcflagValue==12)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for VC PMS Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for VC PMS Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for VC PMS Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for VC PMS Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              ?>
    
                                    <div class="title-links " id="exportbtn"></div>
                                    
                                    
                               <?php }
                                   else 
                                   {
                                   if($vcflagValue==0)
                                   {
                                       ?>    <h2 id="tour_result_title">
                                           <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                            if($dealvalue==101)
                                          {
                                           ?>
                                               <span class="result-for">for PE Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for PE-backed Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for PE Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for PE Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                           </h2>
    
                              <?php }
                                    else if($vcflagValue==1)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                            if($dealvalue==101)
                                          {
                                           ?>
                                               <span class="result-for">for VC Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for VC Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for VC Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for VC Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                                else if($vcflagValue==2)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                       if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Angel Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for  Funded Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==110)
                                          {
                                      ?>
                                              <span class="result-for">for  Fundraising Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Angel Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Angel Transaction Advisors</span>
                                      <?php
                                          }
                                          ?> 
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==3)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Social VC investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Social Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Social Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Social Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==4)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Cleantech Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Cleantech Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==5)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for Infrastructure Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for Infrastructure Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              else if($vcflagValue==6)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                    <?php
                                    if($dealvalue==105)
                                     {
                                      ?>
                                               <span class="result-for">for Incubators</span>
                                      <?php
                                          }
                                          else if($dealvalue==106)
                                          {
                                      ?>
                                              <span class="result-for">for Incubation Incubatee</span>
                                      <?php
                                          }
                                          ?>
                                            <!-- <span class="result-for">for Infrastructure Directory</span> -->
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              else if($vcflagValue==7)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for IPO(PE) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(PE) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==8)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for IPO(VC) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for IPO(VC) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==9)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for PMS Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for PMS Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==10)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for M&A(PE) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(PE) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==11 || $vcflagValue==12)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                             <?php
                                    if($dealvalue==101)
                                     {
                                      ?>
                                               <span class="result-for">for M&A(VC) Investors</span>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Companies</span>
                                      <?php
                                          }
                                          else if($dealvalue==103)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Legal Advisors</span>
                                      <?php
                                          }
                                          else if($dealvalue==104)
                                          {
                                      ?>
                                              <span class="result-for">for M&A(VC) Transaction Advisors</span>
                                      <?php
                                          }
                                          ?>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } ?>
                                    
                             <div class="title-links " id="exportbtn"></div>
                             
                              <?php  
                              if($dealvalue !=111){ 
                             if( $industry > 0 || ($followonVC!="--" && $followonVC!="") || ($exited !="--" && $exitedText !='') || $stagevaluetext!="" || ($round!="--" && $round!=null) || 
                                     ($investorType !="--" && $investorType!=null) || $regionId > 0 || ($txtregion !="--" && $txtregion !="") || ($txtregion !="--" && $txtregion !="")
                                     || ($startRangeValue!= "--") && ($endRangeValue != "") || $city!="" || trim($sdatevalueCheck1) !='' || $keyword!="" || $companysearch!="" || $sectorsearch!=""
                                     || $advisorsearch_trans!="" || $advisorsearch_legal!="" || $dirsearch!="" || (($firmvaluetext!="") && ($firmvaluetext != "--")) || $countrytxt != ""){ ?>
                             
                             <ul class="result-select">
                                <?php
                                $cl_count = count($_POST);
                                if($cl_count > 4)
                                {
                                   ?>
                                <li class="result-select-close" style="border:none;"><a href="pedirview.php?value=<?php echo $vcflagValue; ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                               if($industry >0 && $industry!=null){ ?>
                                <li title="Industry">
                                    <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }if($followonVC!="--" && $followonVC!=""){ ?>
                            <li>
                            <?php echo $followonVCFundText ?><a  onclick="resetinput('followonVCFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } if($exited !="--" && $exitedText !=''){ ?>
                            <li>
                            <?php echo $exitedText?><a  onclick="resetinput('exitedstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }    
                                if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                    if($round!="--" && $round!=null){ $drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $round; ?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                    <?php } 
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($regionId > 0){ ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }   
                                if($txtregion !="--" && $txtregion !=""){ ?>
                            <li>
                            <?php echo $regionText?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } 
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($city!=""){ $drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                <?php } 
                                if (trim($sdatevalueCheck1) !='' && $dealvalue!=111){ ?>
                                <li> 
                                    <?php echo $sdatevalueCheck1. "-" .$edatevalueCheck2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 

                                if($firmvaluetext!="--" && $firmvaluetext!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $firmvaluetext;?><a  onclick="resetinput('firmtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                // echo $cityname;
                                // exit();
                                 if($vcflagValue != 6 && $dealvalue != 103 && $dealvalue != 104){ 
                                    if($countryname!="--" && $countryname!=null && ($cityname != '' || $countryNINname != '')) { $drilldownflag=0; ?>
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
                                                    <?php echo $cross_country." - ".ucwords(strtolower($cityname));?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>        
                                                <?php
                                                    }else{
                                                ?>
                                            <?php echo $cross_country." - ".ucwords(strtolower($cross_city));?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                            <?php }
                                            }else{ ?>
                                                <?php if($countryNINname == "All Countries"){
                                                    ?>
                                                <?php echo $cross_country." - ".ucwords(strtolower($countryNINname));?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                                <?php }else{ ?>
                                                    <?php echo "Non India - ".$cross_country;?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                                <?php } ?>
                                            <?php } ?>
                                        </li>
                                    <?php } 
                                }

                                if($keyword!="") { ?>
                                <li> 
                                    <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!="") { ?>
                                <li> 
                                    <?php echo $companysearch;?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!="") { ?>
                                <li> 
                                    <?php echo $sectorsearch;?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($advisorsearch_trans!="") { ?>
                                <li> 
                                    <?php echo $advisorsearch_trans;?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearch_legal!="") { ?>
                                <li> 
                                    <?php echo $advisorsearch_legal;?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($dirsearch!="") { ?>
                                <li> 
                                    <?php echo $dirsearch;?><a  onclick="resetinput('autocomplete');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo trim($searchallfield)?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                 if ($tagsearch != '') {

                                            $ex_tags_filter = explode(':', $tagsearch);

                                            if (count($ex_tags_filter) > 1) {
                                                $tagsearch = trim($tagsearch);
                                          } else {

                                                $tagsearch = "tag:" . trim($tagsearch);
                                            }
                                            ?>
                                                <li><?php echo $tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
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
                             <?php 
                                   }
                               }else{
                                if($searchallfield !="" || $industry > 0 || ($followonVC!="--" && $followonVC!="") || ($exited !="--" && $exitedText !='') || $stagevaluetext!="" || ($round!="--" && $round!=null) || 
                                     ($investorType !="--" && $investorType!=null) || $regionId > 0 || ($txtregion !="--" && $txtregion !="") || ($txtregion !="--" && $txtregion !="")
                                     || ($startRangeValue!= "--") && ($endRangeValue != "") || $city!=""  || $keyword!="" || $companysearch!="" || $sectorsearch!=""
                                     || $advisorsearch_trans!="" || $advisorsearch_legal!="" || $dirsearch!="" || (($firmvaluetext!="") && ($firmvaluetext != "--")) || $countrytxt != "" || $keyworddir !=""){ ?>
                             
                             <ul class="result-select">
                                <?php
                                $cl_count = count($_POST);
                                if($cl_count > 4)
                                {
                                   ?>
                                <li class="result-select-close" style="border:none;"><a href="pedirview.php?value=<?php echo $vcflagValue; ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                               if($industry >0 && $industry!=null){ ?>
                                <li title="Industry">
                                    <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }if($followonVC!="--" && $followonVC!=""){ ?>
                            <li>
                            <?php echo $followonVCFundText ?><a  onclick="resetinput('followonVCFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } if($exited !="--" && $exitedText !=''){ ?>
                            <li>
                            <?php echo $exitedText?><a  onclick="resetinput('exitedstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }    
                                if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                    if($round!="--" && $round!=null){ $drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $round; ?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                    <?php } 
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($regionId > 0){ ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }   
                                if($txtregion !="--" && $txtregion !=""){ ?>
                            <li>
                            <?php echo $regionText?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } 
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($city!=""){ $drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                <?php } 
                                if (trim($sdatevalueCheck1) !='' && $dealvalue!=111){ ?>
                                <li> 
                                    <?php echo $sdatevalueCheck1. "-" .$edatevalueCheck2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 

                                if($firmvaluetext!="--" && $firmvaluetext!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $firmvaluetext;?><a  onclick="resetinput('firmtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 

                                 if($vcflagValue != 6 && $dealvalue != 103 && $dealvalue != 104){ 
                                    if($countryname!="--" && $countryname!=null && ($cityname != '' || $countryNINname != '')) { $drilldownflag=0; ?>
                                        <li> 
                                            <?php echo $countryname.",".ucwords(strtolower($cityname)).$countryNINname;?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                    <?php } 
                                }

                                if($keyword!="") { ?>
                                <li> 
                                    <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($keyworddir!="") { ?>
                                <li> 
                                    <?php echo $keyworddir;?><a  onclick="resetinput('keywordsearchdir');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!="") { ?>
                                <li> 
                                    <?php echo $companysearch;?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!="") { ?>
                                <li> 
                                    <?php echo $sectorsearch;?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($advisorsearch_trans!="") { ?>
                                <li> 
                                    <?php echo $advisorsearch_trans;?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearch_legal!="") { ?>
                                <li> 
                                    <?php echo $advisorsearch_legal;?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($dirsearch!="") { ?>
                                <li> 
                                    <?php echo $dirsearch;?><a  onclick="resetinput('autocomplete');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo trim($searchallfield)?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                 if ($tagsearch != '') {

                                            $ex_tags_filter = explode(':', $tagsearch);

                                            if (count($ex_tags_filter) > 1) {
                                                $tagsearch = trim($tagsearch);
                                          } else {

                                                $tagsearch = "tag:" . trim($tagsearch);
                                            }
                                            ?>
                                                <li><?php echo $tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
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
                             <?php 
                                   }

                               }
                                } ?>
                                            
                        </div>
                    <br><br><br><br><br>
                       <div class="list-tab"><ul>
                        <li class="active"><a class="postlink"  href="pedirview.php?value=<?php echo $_GET['value'];?>"  id="icon-grid-view"><i></i> List  View</a></li>
                         <?php
                            $count=0;
                            if($vcflagValue!=6)
                            {
                                
                                if($dealvalue==101)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                     $comid = $myrow["InvestorId"];
                                                    $count++;
                                            }
                                    }
                                }
                                else if($dealvalue==102)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                     $comid = $myrow["PECompanyId"];
                                                    $count++;
                                            }
                                    }
                                }
                                else if($dealvalue==103 || $dealvalue==104)
                                {
                                     While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                     $comid = $myrow["CIAId"];
                                                    $count++;
                                            }
                                    }
                                }
                                else if($dealvalue==111)
                                {
                                     While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                     $comid = $myrow["LPId"];
                                                    $count++;
                                            }
                                    }
                                }
                            }
                            else
                            {  
                                if($dealvalue==105)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                    $comid = $myrow["IncubatorId"];
                                                    $count++;
                                            }
                                    }
                                }
                                else if($dealvalue==106){
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            if($count == 0)
                                            {
                                                    $comid = $myrow["IncubateeId"];
                                                    $count++;
                                            }
                                    }
                                    
                                }
                            }
                            if($vcflagValue!=6)
                            {
                                if($dealvalue==101)
                                {
                                    $href="dirdetails.php?value=".$comid;
                                    $directory="";
                                }
                                else if($dealvalue==102){
                                    
                                    $href="companydetails.php?value=".$comid;
                                    $directory="/Directory";
                                }
                                else if($dealvalue==103)
                                {
                                    $href="diradvisor.php?value=".$comid;
                                    $directory="";
                                }
                                else if($dealvalue==104)
                                {
                                    $href="diradvisor.php?value=".$comid;
                                    $directory="";
                                }
                                 else if($dealvalue==111)
                                {
                                    $href="lpdirdetails.php?value=".$comid;
                                    $directory="";
                                }
                        ?>
                        <li><a id="icon-detailed-view" class="postlink" href="<?php echo $href;?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue.$directory;?>" ><i></i> Detail  View</a></li> 
                        <?php
                            }
                            else
                            {
                                if($dealvalue==105)
                                {
                                    $href="dirincdetails.php?value=".$comid;
                                }
                                else if($dealvalue==106){
                                    
                                    $href="companydetails.php?value=".$comid;
                                }
                               ?>
                        <li><a id="icon-detailed-view" class="postlink" href="<?php echo $href;?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>" ><i></i> Detail  View</a></li> 
                        <?php 
                            }
                            ?>
                        
                        
                        <?php if($dealvalue == 110) { ?>
                         <li style="float:right"><img src="img/angle-list.png" alt="angle-list" style="padding:5px;float:right"></li>
                        <?php } ?>
                        
                           </ul></div>
                <?php  $rowlimit=25;
                                $offset=0;
                                $i=1;
                                $j=1;
                                $newrowflag=1;
                                $newcolumnflag=1;
                                $columncount=1;
                                 $columnlimit=4;?>

       
<div class="directory-cnt">  
    
    <?php if($dealvalue != 110){?>
    <div class="search-area" <?php if($dealvalue==111){ echo 'style="display:inline-flex;"';}?>>
             
    <script>
   $(document).ready(function(){
    var tagsearchval = $('#tagsearch').val();
if(tagsearchval == ''){
    $('.acc_trigger.helptag').removeClass('active').next().hide();
}
   


        var search_filter="";
    $("select#tour_month2").change(function(){
        var year1 = $("select#tour_year1").children("option:selected").val();
        var year2 = $("select#tour_year2").children("option:selected").val();
        var month1 = $("select#tour_month1").children("option:selected").val();
        var month2 = $(this).children("option:selected").val();
         console.log(month1);
        console.log(year1);
        console.log(month2);
        console.log(year2);
        if(year1>year2 || month1 > month2){
            alert("To date cannot be less than From date");
            $(this).removeAttr("onchange","this.form.submit();");
            search_filter=1
        }else{
        //$(this).attr("onchange","this.form.submit();");
        //$("#pesearch").submit();
        search_filter="";
        }
        //alert("You have selected the country - " + selectedCountry);
    });
    $("select#tour_month1").change(function(){
        var year1 = $("select#tour_year1").children("option:selected").val();
        var year2 = $("select#tour_year2").children("option:selected").val();
        var month1 = $(this).children("option:selected").val();
        var month2 = $("select#tour_month2").children("option:selected").val();
         console.log(month1);
        console.log(year1);
        console.log(month2);
        console.log(year2);
        var startdate= new Date(year1,month1-1,01);
        var enddate= new Date(year2,month2-1,01);
        //if(year1>year2 || month1 > month2){
        if(startdate>enddate ){
            alert("To date cannot be less than From date");
            $(this).removeAttr("onchange","this.form.submit();");
            search_filter=1
        }else{
        //$(this).attr("onchange","this.form.submit();");
        //$("#pesearch").submit();
        search_filter="";
        }
        //alert("You have selected the country - " + selectedCountry);
    });
    $("select#tour_year2").change(function(){
        var year2 = $(this).children("option:selected").val();
        var year1 = $("select#tour_year1").children("option:selected").val();
        var month1 = $("select#tour_month1").children("option:selected").val();
        var month2 = $("select#tour_month2").children("option:selected").val();
        
        console.log(month1);
        console.log(year1);
        console.log(month2);
        console.log(year2);
        if(year1>year2 || month1 > month2){
            alert("To date cannot be less than From date");
            $(this).removeAttr("onchange","this.form.submit();");
            search_filter=1
        }else{
        $(this).attr("onchange","this.form.submit();");
        $("#pesearch").submit();
        search_filter="";
        }
        //alert("You have selected the country - " + selectedCountry);
    });
    $("select#tour_year1").change(function(){
        var year1 = $(this).children("option:selected").val();
        var year2 = $("select#tour_year2").children("option:selected").val();
        var month1 = $("select#tour_month1").children("option:selected").val();
        var month2 = $("select#tour_month2").children("option:selected").val();
        console.log(year2);
        console.log(year1);
        if(year1>year2 || month1 > month2){
            alert("To date cannot be less than From date");
            $(this).removeAttr("onchange","this.form.submit();");
            search_filter=1
        }else{
        $(this).attr("onchange","this.form.submit();");
        $("#pesearch").submit();
        search_filter="";
        }
        //alert("You have selected the country - " + selectedCountry);
    });
    $("input#searchsub").click(function(){
       // console.log("check");
        if(search_filter!=1)
            {
                //console.log("check1");
                $("#pesearch").submit();
                search_filter="";
            }
            else{
              //  console.log("check2");
                alert("To date cannot be less than From date");
            $(this).removeAttr("onchange","this.form.submit();");
            search_filter=1;
            }
       
    });
});
            $(function() {
            var autodata = [
            <?php
            /* populating the investortype from the investortype table */
        $searchStrings="Undisclosed";
            $searchStrings=strtolower($searchStrings);
        
            $searchStrings1="Unknown";
            $searchStrings1=strtolower($searchStrings1);
        
            $searchStrings2="Others";
            $searchStrings2=strtolower($searchStrings2);
        if($dealvalue==101) 
                {
                        if($vcflagValue==2)
                        {
                            if($searchallfield !=''){
                             $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " ( MoreInfor LIKE '%$searchallfield%' or inv.investor like '%$searchallfield%' or Description like '%$searchallfield%') "
                                     . " order by inv.Investor ";
                            }else{
                             $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                            }
                        }
                        else if($vcflagValue==7 || $vcflagValue==8)
                        {
                             /*$getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";*/
                            $getInvestorSqls = "SELECT DISTINCT inv.InvestorId, inv.Investor
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE ";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    //$dt1 = "1998-01-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " IPODate between '1998-01-01' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates !== "") )
                               {
                                        $getInvestorSqls = $getInvestorSqls . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $getInvestorSqls=$getInvestorSqls . $whereind ." and ";
                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $getInvestorSqls = $getInvestorSqls. " pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                          
                        }
                        else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                              /*$getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";*/
                                $getInvestorSqls = "SELECT DISTINCT inv.InvestorId, inv.Investor
                                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv WHERE ";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    //$dt1 = "1998-01-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " DealDate between '1998-01-01' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates !== "") )
                               {
                                        $getInvestorSqls = $getInvestorSqls . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $getInvestorSqls=$getInvestorSqls . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $getInvestorSqls = $getInvestorSqls. " pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                        }
                        elseif($vcflagValue==3 ||$vcflagValue==4 || $vcflagValue==5)
                        {
                            $getInvestorSqls = "select distinct peinv.InvestorId,inv.Investor,inv.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb where ";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                        //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."'";
                                            }
                                        //
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    //$dt1 = "1998-01-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '1998-01-01' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates !== "") )
                               {
                                        $getInvestorSqls = $getInvestorSqls . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $getInvestorSqls=$getInvestorSqls . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               if($whereRound !="")
                                        {
                                            $getInvestorSqls=$getInvestorSqls.$whereRound." and ";
                                        }
                                if (($wherestage != ""))
                                {
                                        $getInvestorSqls=$getInvestorSqls. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $getInvestorSqls=$getInvestorSqls . $whereRound . " and " ;
                                        }  
                                if (($whereInvType != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSqls=$getInvestorSqls.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $getInvestorSqls = $getInvestorSqls. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                            
                        }
                        else {
                                $getInvestorSqls ="SELECT DISTINCT inv.InvestorId as InvestorId, inv.Investor as Investor, 1 as investmenttype
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0
                                       
                                UNION
                                select distinct peinv.InvestorId as InvestorId,inv.Investor as Investor, 2 as investmenttype
                               from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                 where
                                 pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                 pe.StageId=s.StageId and pec.industry!=15 and
                                 pe.Deleted=0
                                UNION
                SELECT DISTINCT pe.IncubatorId as InvestorId, inc.Incubator as Investor, 5 as investmenttype
                FROM incubatordeals AS pe,  incubators as inc
                                    WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 and inc.Incubator!='' order by Investor";
                        }
                        /* $getInvestorSqls ="SELECT DISTINCT inv.InvestorId as InvestorId, inv.Investor as Investor, 1 as investmenttype
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0
                                       
                                UNION
                                select distinct peinv.InvestorId as InvestorId,inv.Investor as Investor, 2 as investmenttype
                               from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                 where
                                 pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                 pe.StageId=s.StageId and pec.industry!=15 and
                                 pe.Deleted=0
                                 UNION
                                SELECT DISTINCT inv.InvestorId as InvestorId, inv.Investor as Investor, 3 as investmenttype
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0
                UNION
                SELECT DISTINCT inv.InvestorId as InvestorId, inv.Investor as Investor, 4 as investmenttype
                                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv WHERE
                                                pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0
                UNION
                SELECT DISTINCT pe.IncubatorId as InvestorId, inc.Incubator as Investor, 5 as investmenttype
                FROM incubatordeals AS pe,  incubators as inc
                                    WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 order by Investor";
                        }*/
                       // echo $getInvestorSqls;
                       // exit();
                        if ($rsinvestors = mysql_query($getInvestorSqls)){
                                $investors_cnts = mysql_num_rows($rsinvestors);
                        }
            
                        if($investors_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                              $commacount=0;
                             While($myrows=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                                    $Investornames=trim($myrows["Investor"]);
                                                    $Investornames=strtolower($Investornames);

                                                    $invResults=substr_count($Investornames,$searchStrings);
                                                    $invResults1=substr_count($Investornames,$searchStrings1);
                                                    $invResults2=substr_count($Investornames,$searchStrings2);

                                                    if(($invResults==0) && ($invResults1==0) && ($invResults2==0)){
                                                            $investorsId = $myrows["InvestorId"];
                                                            $investors = $myrows["Investor"];
                                                            $investmenttype = $myrows["investmenttype"];
                                                            
                                                              if($commacount>0)
                                                                echo ",";
                                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($investors)) ? 'SELECTED' : '';
                                                            echo "{value : '".$investors."',id : ".$investorsId.",type : '".$investmenttype."'}" ;
                                                            //echo "'".$investors."'";
                                                             $commacount++;
                                                    }
                            }
                    }
                }
                else if($dealvalue==102)
                {
                     if($vcflagValue==2)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.InvesteeId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                                        ORDER BY pec.companyname";
                        }
                        else if($vcflagValue==3 ||$vcflagValue==4 || $vcflagValue==5)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                                            ORDER BY pec.companyname";
                        }
                        else if($vcflagValue==7 || $vcflagValue==8)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                WHERE pec.PECompanyId = pe.PEcompanyId 
                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                ORDER BY pec.companyname";
                          
                        }
                        else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                WHERE pec.PECompanyId = pe.PEcompanyId 
                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                AND r.RegionId = pec.RegionId " .$addVCFlagqry. " 
                ORDER BY pec.companyname";
                        }
                        else {
                             $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                                        ORDER BY pec.companyname";
                        }
                  
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
            
                        if( $companies_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                               $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $companies = $myrow["companyname"];
                                            $companyId= $myrow["PECompanyId"];
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                              if($commacount>0)
                                                echo ",";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            echo '{value : "'.$companies.'",id : '.$companyId.'}' ;
                                            //echo "'".$companies."'";
                                            $commacount++;
                                        }
                                }                          
                    }
                }
                else if($dealvalue==103)
                {     
                    
                        $adtype="L";
                   
                     
                        if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                           $advisorsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                         " )    ORDER BY Cianame";
                           // echo $advisorsql;
                        }
                        elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
                        {
                            $advisorsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' 
                AND adac.PEId = peinv.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' 
                AND adac.PEId = peinv.PEId $comp_industry_id_where) order by Cianame";
                             
                             
                             //echo $advisorsql;
                        }
                        else{
                             $advisorsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s
                WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                " AND c.PECompanyId = pe.PECompanyId
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                AND adac.PEId = pe.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s
                WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                "  AND c.PECompanyId = pe.PECompanyId
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                AND adac.PEId = pe.PEId $comp_industry_id_where ) order by Cianame";
                             
                             
                            // echo $advisorsql;
                        }
                        if ($rsinvestors = mysql_query($advisorsql)){
                                $advisor_cnts = mysql_num_rows($rsinvestors);
                        }
            
                        if($advisor_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                             $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["Cianame"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($commacount>0)
                                                echo ",";
                                            $advisors = $myrow["Cianame"] ;
                                            $advisorId = $myrow["CIAId"] ;
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($advisors)) ? 'SELECTED' : '';
                                            echo "{value : '".$advisors."',id : ".$advisorId."}" ;
                                            //echo "'".$advisors."'";
                                            $commacount++;
                                        }
                                }                          
                    }
                }
                else if($dealvalue==104)
                {  
                        $adtype="T";
                    
                     
                        if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                           $advisorsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.$comp_industry_id_where.
                                         " )    ORDER BY Cianame";
                            //echo $advisorsql;
                        }
                        elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
                        {
                            $advisorsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' 
                AND adac.PEId = peinv.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' 
                AND adac.PEId = peinv.PEId $comp_industry_id_where ) order by Cianame";
                             
                             
                             //echo $advisorsql;
                        }
                        else{
                             $advisorsql="(
                SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac, stage as s
                WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                " AND c.PECompanyId = pe.PECompanyId
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                AND adac.PEId = pe.PEId $comp_industry_id_where)
                UNION (
                SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac, stage as s
                WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                "  AND c.PECompanyId = pe.PECompanyId
                AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                AND adac.PEId = pe.PEId $comp_industry_id_where) order by Cianame";
                             
                             
                             //echo $advisorsql;
                        }
                        if ($rsinvestors = mysql_query($advisorsql)){
                                $advisor_cnts = mysql_num_rows($rsinvestors);
                        }
            
                        if($advisor_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                             $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["Cianame"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($commacount>0)
                                                echo ",";
                                            $advisors = $myrow["Cianame"] ;
                                            $advisorId = $myrow["CIAId"] ;
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($advisors)) ? 'SELECTED' : '';
                                            echo "{value : '".$advisors."',id : ".$advisorId."}" ;
                                            //echo "'".$advisors."'";
                                            $commacount++;
                                        }
                                }                          
                    }
                }
                else if($dealvalue==105)
                {
                     if($vcflagValue==6)
                        {
                            if($searchallfield !=''){
                            $getcompaniesSql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                FROM incubatordeals AS pe,  incubators as inc
                                    WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0  and inc.Incubator != '' and ( inc.Incubator like '$searchallfield%' or inc.City LIKE '$searchallfield%'
                                            OR inc.AdditionalInfor like '%$searchallfield%' or pe.MoreInfor like '%$searchallfield%')
                                     order by inc.Incubator ";
                                
                            }else{
                                $getcompaniesSql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                                    FROM incubatordeals AS pe,  incubators as inc
                WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0  and inc.Incubator != '' 
                 order by inc.Incubator ";
                            }
                            
                        }
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
            
                        if( $companies_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                             $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["Incubator"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($commacount>0)
                                                echo ",";
                                            $companies = $myrow["Incubator"];
                                            $incubatorId = $myrow["IncubatorId"];
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            echo "{value : '".$companies."',id : ".$incubatorId."}" ;
                                            //echo "'".$companies."'";
                                            $commacount++;
                                        }
                                }                          
                    }
                }
                else if($dealvalue==106)
                {
                     if($vcflagValue==6)
                        {
                            if($searchallfield !=''){
                            $getcompaniesSql="SELECT DISTINCT pe.IncubateeId, pec. *
                FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                                     and pe.Deleted=0 and pec.industry!=15 and ( pec.companyname like '%$searchallfield%' or pec.city LIKE '$searchallfield%'
                                            OR pec.AdditionalInfor like '%$searchallfield%' or pe.MoreInfor like '%$searchallfield%' or pec.tags like '%$searchallfield%')
                                    ORDER BY pec.companyname";                                
                            }else{
                                $getcompaniesSql="SELECT DISTINCT pe.IncubateeId, pec. *
                                    FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                                    WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                 and pe.Deleted=0 and pec.industry!=15
                ORDER BY pec.companyname";
                        }
                        }
                  
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
            
                        if( $companies_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                               $commacount=0;
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($commacount>0)
                                                echo ",";
                                            $companies = $myrow["companyname"];
                                            $incubateeId = $myrow["IncubateeId"];
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            echo "{value : '".$companies."',id : ".$incubateeId."}" ;
                                            
                                            //echo "'".$companies."'";
                                             $commacount++;
                                        }
                                }                          
                    }
                }
                 else if($dealvalue==110)
                {
                    $angelCoAutosql="SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   ORDER BY a.company_name";
                            
                     
                     $angelcoQuery = mysql_query($angelCoAutosql);
                                         
                        $totalAngelcount = mysql_num_rows($angelcoQuery);
                        $countComma=0;
                       While($myrow=mysql_fetch_array($angelcoQuery, MYSQL_BOTH))
                       {
                          
                                   if($myrow['PECompanyId']!='' && $myrow['PECompanyId']>0){
                                       $data = "value=".$myrow['PECompanyId']."/$vcflagValue/110"; 
                                   }
                                   elseif($myrow['angel_id']!='' && $myrow['angel_id']>0){
                                       $data = "value=".$myrow['angel_id']."/$vcflagValue/110&angelco_only"; 
                                   }

                            if($countComma > 0){
                                echo ", ";
                            } 
                            $company_name = addslashes($myrow['company_name']);
                           
                         //  $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                           echo "{value : '".$company_name."', id:'"."$data"."'}" ;
                           
                           
                           $countComma++;


                    }                          
                    
                }
                else if($dealvalue==111)
                {
                    $getcompaniesSql="SELECT a.* FROM limited_partners as a ORDER BY a.InstitutionName";
                       
                     
                     if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
                        $countComma=0;
                       While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                       {
                          
                                   if($myrow['LPId']!='' && $myrow['LPId']>0){
                                       $data = "value=".$myrow['LPId']."/$vcflagValue/111"; 
                                   }
                                  

                            if($countComma > 0){
                                echo ", ";
                            } 
                            $company_name = addslashes($myrow['InstitutionName']);
                           
                         //  $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                           echo "{value : '".$company_name."', id:'"."$data"."'}" ;
                           
                           
                           $countComma++;


                    }                          
                    
                }
    ?>
            ];
            $( "#investorautodir" ).autocomplete({
      source: function( request, response ) {
        $('#keywordsearch1').val('');
        $.ajax({
            type: "POST",
          url: "ajaxInvestorDetails.php",
          dataType: "json",
          data: {
            vcflag: '<?php echo $vcflagValue; ?>',
            search: request.term,
            showallcompInvFlag:'<?php echo $showallcompInvFlag; ?>'
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.label,
                value: item.value,
                 id: item.id
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#keywordsearchdir').val(ui.item.value);
       $( "#investorautodir" ).val( ui.item.value);
            $( "#compiddir" ).val( ui.item.id);
            idval=$("#compiddir").val();
           /* if(<?php echo $dealvalue;?>==111)
                    {
                        $("#lpdetailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                    }*/
      
//      $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#keywordsearchdir').val()=="")
             $( "#investorautodir" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
       
    }); 
            $('#autocomplete').keypress(function (e) {
                if (e.which == 13) {
                //13 is the Enter Key - keycode
                $("#pesearch").submit();
                    return false; //<---- Add this line
                }
                else{
                    $( "#autocomplete" ).autocomplete({
                        minLength: 0,
                        source: autodata,
                        focus: function( event, ui ) {
                        $( "#autocomplete" ).val( ui.item.value );
                        return false;
                        },
                        select: function( event, ui ) {
                        $( "#autocomplete" ).val( ui.item.value);
                        $( "#compid" ).val( ui.item.id);
                        $("#investortype_auto").val(ui.item.type);
                       // $( "#compid" ).attr( "investortype" ,ui.item.type);
                        idval=$("#compid").val();
                        typeval=$("#investortype_auto").val();
                            if(Directorydemotour==1) {
               
                                if(idval==42){
                                $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                                }
                                else {
                                    showErrorDialog(warmsg);
                                    $("#detailpost").attr("href","javascript:").trigger("click"); 
                                    $("#autocomplete").val(''); 
                                }
                            }
                            else{
                                    if(<?php echo $dealvalue;?>==101)
                                    {
                                        if(typeval==1){
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirdetails.php?value="+idval+"/2/<?php echo $dealvalue;?>").trigger("click");
                                        }else if(typeval==2){
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirdetails.php?value="+idval+"/0/<?php echo $dealvalue;?>").trigger("click");
                                        }else if(typeval==3){
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirdetails.php?value="+idval+"/7/<?php echo $dealvalue;?>").trigger("click");
                                        }else if(typeval==4){
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirdetails.php?value="+idval+"/10/<?php echo $dealvalue;?>").trigger("click");
                                        }else if(typeval==5){    
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirincdetails.php?value="+idval+"/6/<?php echo $dealvalue;?>").trigger("click");
                                        }else{
                                        	 $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                                        }
                                    }
                                    else if(<?php echo $dealvalue;?>==102)
                                    {
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/companydetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>/<?php echo $topNav; ?>").trigger("click");
                                    }
                                    else if(<?php echo $dealvalue;?>==103)
                                    {
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/diradvisor.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                                    }
                                    else if(<?php echo $dealvalue;?>==104)
                                    {
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/diradvisor.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                                    }
                                    else if(<?php echo $dealvalue;?>==105)
                                    {
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dirincdetails.php?value="+idval+"/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>").trigger("click");
                                    }
                                    else if(<?php echo $dealvalue;?>==110)
                                    {
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/companydetails.php?"+idval).trigger("click");
                                    }
                                    else if(<?php echo $dealvalue;?>==111)
                                    {
                                        $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/lpdirdetails.php?"+idval).trigger("click");
                                    }
                                }
                            return false;
                            } 
                    });
                }
            });
            });
    </script>
    <!--  <a id="detailpost" class="postlink"></a> 
    <input type="text" id="autocomplete"  name="autocomplete" type="text" placeholder="Directory Search" value="<?php echo $dirsearch; ?>">
    <a type="text" id="compid" ></a>
    <input type="button" id="searchsub" name="fliter_dir" value="" onclick="this.form.submit();"><br> -->
    <?php if($dealvalue!=111){?>
     <a id="detailpost" class="postlink"></a> 
    
    <input type="text" id="autocomplete"  name="autocomplete" type="text" placeholder="Directory Search" value="<?php echo $dirsearch; ?>">
    <a type="text" id="compid" ></a>
    <input type="hidden" id="investortype_auto"/>
    <input type="button" id="searchsub" name="fliter_dir" value="" onclick="this.form.submit();"><br>
        <?php }else{?>
    <a id="detailpost" class="postlink"></a> 
    <input type="text" id="autocomplete"  name="autocomplete" type="text" placeholder="LimitedPartners Search" value="<?php echo $dirsearch; ?>">
    <a type="text" id="compid" ></a>
    <input type="button" id="searchsub" name="fliter_dir" value="" onclick="this.form.submit();"><br>
<?php }?>
    <?php if($dealvalue == 111){ ?>
        <a id="lpdetailpost" class="postlink"></a> 
         <input type="text" id="investorautodir" name="investorautodir" value="<?php if(isset($_POST['keywordsearchdir'])) echo  $_POST['keywordsearchdir'];  ?>" placeholder="Investor search" style="width:220px;margin-left:10px;" >
           <a type="text" id="compiddir" ></a>
     <input type="hidden" id="keywordsearchdir" name="keywordsearchdir" value="<?php if(isset($_POST['keywordsearchdir'])) echo  $_POST['keywordsearchdir'];  ?>" placeholder="" style="width:220px;">
    <input type="button" id="searchsub" name="fliter_dir" value="" onclick="this.form.submit();">
<?php }
    ?>
    
    <?php if($vcflagValue != 6 && $dealvalue != 103 && $dealvalue != 104 && $dealvalue != 102 && $dealvalue != 111){ ?>
        <div class="filter-area">
        
        <select name="country" id="country" onchange="openCity(this);">
        <option value=""></option>
            <option value="IN" <?php if($countrytxt == 'IN') { echo "selected"; }?>>India</option>
            <option value="NIN" <?php if($countrytxt == 'NIN') { echo "selected"; }?>>Non-India</option>
        </select>
        <div class="selectgroup countryNIN" id="country_div" <?php if($countrytxt == "" || $countrytxt != "NIN") { echo 'style="display:none;"';}?> >
        <select name="countryNIN[]" multiple id="countryNIN" >
        <!-- <option value="All"> All Countries </option> -->
            <?php
                //$countrysql = "SELECT DISTINCT (peinvestors.countryid),country.country from peinvestors JOIN country on country.countryid=peinvestors.countryid ORDER BY country ASC";
                if($vcflagValue == 4 || $vcflagValue == 5 || $vcflagValue == 3){
                    $countrysql = "SELECT DISTINCT(inv.countryid),cou.country
                    FROM peinvestments_investors AS peinv, peinvestments AS pe, pecompanies AS pec, peinvestors AS inv, peinvestments_dbtypes AS pedb,country AS cou
                    WHERE pe.PECompanyId = pec.PECompanyId
                    AND peinv.PEId = pe.PEId
                    AND inv.InvestorId = peinv.InvestorId
                    AND pedb.PEId = pe.PEId
                    AND inv.countryid = cou.countryid
                    AND pedb.DBTypeId = '$dbtype'
                    ORDER BY cou.country";
                } else {
                    $countrysql = "SELECT DISTINCT (peinvestors.countryid),country.country from peinvestors JOIN country on country.countryid=peinvestors.countryid ORDER BY country ASC";
                }
                if ($countryrs = mysql_query($countrysql))
                {
                    $ind_cnt = mysql_num_rows($countryrs);
                }
                if($ind_cnt > 0)
                {
                    While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
                    {
                        $id = $myrow[0];
                        $name = $myrow[1];
                        
                        if($id != "IN" && $id != "10" && $id != "11" && $id != "" && $id != "--" ){ 
                            $indSel = (in_array($id,$countryNINidList))?'selected':'';
                            
                            ?>
                            
                            <option value="<?php echo $id; ?>" id="country_<?php echo $id; ?>" <?php echo $indSel; ?>><?php echo $name; ?></option>
                        <?php } else { ?>
                            
                        <?php } 
                    }
                    mysql_free_result($countryrs);
                }
            ?>
        </select>
        <input type="button" id="searchsub" class="city_country_filter_btn" style="float: right;margin-left: 0px;height: 28px; display: inline-block;" name="fliter_dir" value="" onclick="this.form.submit();">
        </div>
        <div class="selectgroup citysearch" id="city_div" <?php if($countrytxt == "" || $countrytxt != "IN") { echo 'style="display:none;"';}?>>
        <select name="city[]" multiple id="city" >
           
            <?php
            
                $citysql = "select distinct(c.city_name),c.city_id from city as c GROUP BY c.city_name ORDER BY c.city_name ASC";
                if ($cityrs = mysql_query($citysql))
                {
                    $ind_cnt = mysql_num_rows($cityrs);
                }
                if($ind_cnt > 0)
                {
                    While($myrow=mysql_fetch_array($cityrs, MYSQL_BOTH))
                    {
                        $name = $myrow[0];
                        $id = $myrow[1];
                        //echo "<option value=".$name.">".$name."</option>\n";
                        if(count($city)>0){ 
                            $indSel = (in_array($id,$cityid))?'selected':''; 
                            $name =ucwords(strtolower($name));
                            echo "<OPTION id='city_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";  
                            // $selected = 'selected'; 
                            // echo "<option value=".$id." $selected>" . $name . "</option> \n";
                        } else {
                            echo "<option value=".$id.">".$name."</option>\n";
                        }
                    }
                    mysql_free_result($cityrs);
                }
            ?>
        </select>
        <input type="button" id="searchsub" class="city_country_filter_btn" style="float: right; margin-left: 0px; height: 28px;display: inline-block;" name="fliter_dir" value="" onclick="this.form.submit();">
        </div>
        
        </div>
       
    <?php }?>

    <?php if($vcflagValue==0 && $dealvalue==101){ ?>
       <!--  <div style="float:left;margin-top:30px;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>"><h3>Most Active Investors</h3></a></div> -->
        <div class="title-links "> <div class="tab-view-btn" style="float:right;margin-top:-18px;" ><span style="display: inline-block;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>">Most Active Investors</a></span>
            <span class="separator">|</span><span style="display: inline-block;"><a href="newinvestorreport.php?flag=<?php echo $vcflagValue; ?>">New Investors</a></span></div></div>
    <?php }else if($vcflagValue==1 && $dealvalue==101){ ?>
        
      <!--   <div style="float:left;margin-top:30px;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>"><h3>Most Active Investors</h3></a></div>   -->
      <div class="title-links "> <!-- <h3 class="investor-title">Investors</h3> --><div style="float:right;margin-top:-18px;" ><span style="display: inline-block;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>">Most Active Investors</a></span>
            <span class="separator">|</span><span style="display: inline-block;"><a href="newinvestorreport.php?flag=<?php echo $vcflagValue; ?>">New Investors</a></span></div></div>
    <?php }else if($vcflagValue==3 && $dealvalue==101){ ?><!-- Social-->
        
      <!--   <div style="float:left;margin-top:30px;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>"><h3>Most Active Investors</h3></a></div>   -->
      <div class="title-links "> <!-- <h3 class="investor-title">Investors</h3> --><div style="float:right;margin-top:-18px;" ><span style="display: inline-block;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>">Most Active Investors</a></span>
           <!--  <span class="separator">|</span><span style="display: inline-block;"><a href="newinvestorreport.php?flag=<?php echo $vcflagValue; ?>">New Investors</a></span> --></div></div>
    <?php }else if($vcflagValue==4 && $dealvalue==101){ ?><!-- CT-->
        
      <!--   <div style="float:left;margin-top:30px;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>"><h3>Most Active Investors</h3></a></div>   -->
      <div class="title-links "> <!-- <h3 class="investor-title">Investors</h3> --><div style="float:right;margin-top:-18px;" ><span style="display: inline-block;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>">Most Active Investors</a></span>
            <!-- <span class="separator">|</span><span style="display: inline-block;"><a href="newinvestorreport.php?flag=<?php echo $vcflagValue; ?>">New Investors</a></span> --></div></div>
    <?php }else if($vcflagValue==5 && $dealvalue==101){ ?><!-- Infrastructure-->
        
      <!--   <div style="float:left;margin-top:30px;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>"><h3>Most Active Investors</h3></a></div>   -->
      <div class="title-links "> <!-- <h3 class="investor-title">Investors</h3> --><div style="float:right;margin-top:-18px;" ><span style="display: inline-block;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>">Most Active Investors</a></span>
            <!-- <span class="separator">|</span><span style="display: inline-block;"><a href="newinvestorreport.php?flag=<?php echo $vcflagValue; ?>">New Investors</a></span> --></div></div>
    <?php }else if($vcflagValue==2 && $dealvalue==101 ){ ?> <!-- Angel-->
        
      <!--   <div style="float:left;margin-top:30px;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>"><h3>Most Active Investors</h3></a></div>   -->
      <div class="title-links "> <!-- <h3 class="investor-title">Investors</h3> --><div style="float:right;margin-top:-18px;" ><span style="display: inline-block;"><a href="investorreport.php?flag=<?php echo $vcflagValue; ?>">Most Active Investors</a></span>
            <!-- <span class="separator">|</span><span style="display: inline-block;"><a href="newinvestorreport.php?flag=<?php echo $vcflagValue; ?>">New Investors</a></span> --></div></div>
    <?php } ?>
    </div>
     <div class="clearfix"></div>
    <?php } else{ ?>
    <div class="search-area">
        <?php  if(!isset($_POST['angelsearchtype'])){ ?>
        <label style="float: left;" ><input type="radio" name="angelsearchtype" class="angelfilter" value="1" >Company/Location Search</label>
        <label style="float: left; margin-left: 15px;"  ><input type="radio" name="angelsearchtype" class="angelfilter"  value="2" checked="checked">Raising Amount (US $ K)</label>
        <br><br>
        <input type="text" id="company_location"   name="company_location" type="text" placeholder="Company/Location Search"  style="display: none"  > 
        <input type="text" id="raising_amount" value="10" name="raising_amount" type="text" placeholder="Raising Amount From"> 
        <?php } else { ?>
        <label style="float: left;" ><input type="radio" name="angelsearchtype" class="angelfilter" value="1" <?php if($_REQUEST['angelsearchtype']==1){ echo 'checked'; } ?> >Company/Location Search</label>
        <label style="float: left; margin-left: 15px;"  ><input type="radio" name="angelsearchtype" class="angelfilter"  value="2" <?php if($_REQUEST['angelsearchtype']==2){ echo 'checked'; } ?> >Raising Amount (US $ K)</label>
        <br><br>
        <input type="text" id="company_location"   value="<?php  echo $_REQUEST['company_location']; ?>"  name="company_location" type="text" placeholder="Company/Location Search"  <?php if($_REQUEST['angelsearchtype']==2){ echo 'style="display: none"'; } ?>    > 
        <input type="text" id="raising_amount" value="<?php  echo $_REQUEST['raising_amount']; ?>" name="raising_amount" type="text" placeholder="Raising Amount From"  <?php if($_REQUEST['angelsearchtype']==1){ echo 'style="display: none"'; } ?>  >      
       <?php } ?>
        
        <input type="hidden" value="<?php  echo $_GET['s']; ?>" name="ss">
    <input type="button" id="searchsub" name="angelco_filter" value="" onclick="this.form.submit();">
    
    <div style="float:right;"><a href="investorreport"><h4>Most Active Investors</h4></a></div>
    </div>
    <?php } ?>
    
    
<h3 id="showbylist_tour">Show by:</h3>
<div class="show-by-list" >
        <ul><li>
    <a href="pedirview.php?value=<?php echo $_GET['value']?>&s=&sv=<?php echo $dealvalue;?>" class="postlink <?php if($_GET['s']==''){?> active<?php } ?>" >All</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=a&sv=<?php echo $dealvalue;?>" class="postlink <?php if('a'==$_GET['s']){?> active<?php }?>">A</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=b&sv=<?php echo $dealvalue;?>" class="postlink <?php if('b'==$_REQUEST['s']){?> active<?php }?>">B</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=c&sv=<?php echo $dealvalue;?>" class="postlink <?php if('c'==$_REQUEST['s']){?> active<?php }?>">C</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=d&sv=<?php echo $dealvalue;?>" class="postlink <?php if('d'==$_REQUEST['s']){?> active<?php }?>">D</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=e&sv=<?php echo $dealvalue;?>" class="postlink <?php if('e'==$_REQUEST['s']){?> active<?php }?>">E</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=f&sv=<?php echo $dealvalue;?>" class="postlink <?php if('f'==$_REQUEST['s']){?> active<?php }?>">F</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=g&sv=<?php echo $dealvalue;?>" class="postlink <?php if('g'==$_REQUEST['s']){?> active<?php }?>">G</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=h&sv=<?php echo $dealvalue;?>" class="postlink <?php if('h'==$_REQUEST['s']){?> active<?php }?>">H</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=i&sv=<?php echo $dealvalue;?>" class="postlink <?php if('i'==$_REQUEST['s']){?> active<?php }?>">I</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=j&sv=<?php echo $dealvalue;?>" class="postlink <?php if('j'==$_REQUEST['s']){?> active<?php }?>">J</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=k&sv=<?php echo $dealvalue;?>" class="postlink <?php if('k'==$_REQUEST['s']){?> active<?php }?>">K</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=l&sv=<?php echo $dealvalue;?>" class="postlink <?php if('l'==$_REQUEST['s']){?> active<?php }?>">L</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=m&sv=<?php echo $dealvalue;?>" class="postlink <?php if('m'==$_REQUEST['s']){?> active<?php }?>">M</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=n&sv=<?php echo $dealvalue;?>" class="postlink <?php if('n'==$_REQUEST['s']){?> active<?php }?>">N</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=o&sv=<?php echo $dealvalue;?>" class="postlink <?php if('o'==$_REQUEST['s']){?> active<?php }?>">O</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=p&sv=<?php echo $dealvalue;?>" class="postlink <?php if('p'==$_REQUEST['s']){?> active<?php }?>">P</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=q&sv=<?php echo $dealvalue;?>" class="postlink <?php if('q'==$_REQUEST['s']){?> active<?php }?>">Q</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=r&sv=<?php echo $dealvalue;?>" class="postlink <?php if('r'==$_REQUEST['s']){?> active<?php }?>">R</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=s&sv=<?php echo $dealvalue;?>" class="postlink <?php if('s'==$_REQUEST['s']){?> active<?php }?>">S</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=t&sv=<?php echo $dealvalue;?>" class="postlink <?php if('t'==$_REQUEST['s']){?> active<?php }?>">T</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=u&sv=<?php echo $dealvalue;?>" class="postlink <?php if('u'==$_REQUEST['s']){?> active<?php }?>">U</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=v&sv=<?php echo $dealvalue;?>" class="postlink <?php if('v'==$_REQUEST['s']){?> active<?php }?>">V</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=w&sv=<?php echo $dealvalue;?>" class="postlink <?php if('w'==$_REQUEST['s']){?> active<?php }?>">W</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=x&sv=<?php echo $dealvalue;?>" class="postlink <?php if('x'==$_REQUEST['s']){?> active<?php }?>">X</a></li>
    <li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=y&sv=<?php echo $dealvalue;?>" class="postlink <?php if('y'==$_REQUEST['s']){?> active<?php }?>">Y</a></li><li><a href="pedirview.php?value=<?php echo $_GET['value']?>&s=z&sv=<?php echo $dealvalue;?>" class="postlink <?php if('z'==$_REQUEST['s']){?> active<?php }?>">Z</a></li>
</ul></div>  
    
                        <?php
                        if($notable==false)
                        { 
                        ?>
            <div class="list-view-table">
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTables">
                              <thead><tr>
                                      <?php
                                      if($vcflagValue == 0)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Advisors</th>
                                      <?php
                                          }
                                           else if($dealvalue==111)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Limited Partners</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 1)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Advisors</th>
                                      <?php
                                          }
                                            else if($dealvalue==111)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Limited Partners</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 2)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Angel Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of  Funded Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==110)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of  Fundraising Companies</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 3)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social VC Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social Advisors</th>
                                      <?php
                                          }
                                          else if($dealvalue==111)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Limited Partners</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 4)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Advisors</th>
                                      <?php
                                          }
                                          else if($dealvalue==111)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Limited Partners</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 5)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Advisors</th>
                                      <?php
                                          }
                                          else if($dealvalue==111)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Limited Partners</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 6)
                                      {
                                          if($dealvalue==105)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Incubator</th>
                                      <?php
                                          }
                                          else if($dealvalue==106)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Incubatee</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 7)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(PE) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(PE) Companies</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 8)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(VC) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(VC) Companies</th>
                                      <?php
                                          }
                                          
                                      }
                                      else if($vcflagValue == 9)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Advisors</th>
                                      <?php
                                          }
                                          else if($dealvalue==111)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Limited Partners</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 10)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Advisors</th>
                                      <?php
                                          }
                                          else if($dealvalue==111)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Limited Partners</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 11)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Advisors</th>
                                      <?php
                                          }
                                          else if($dealvalue==111)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Limited Partners</th>
                                      <?php
                                          }
                                      }
                                      ?>
                              </tr></thead>
                              <tbody id="movies">
                                <?php
                                        //Code to add PREV /NEXT
                                        $icount = 0;
                                        if ($_SESSION['investeeId']) 
                                            unset($_SESSION['investeeId']);
                                        if ($_SESSION['resultCompanyId']) 
                                            unset($_SESSION['resultCompanyId']); 
                                        if ($_SESSION['resultCompanyId']) 
                                            unset($_SESSION['resultCompanyId']);
                                        if ($_SESSION['IncubatorId'])
                                             unset($_SESSION['IncubatorId']);
                                        if ($_SESSION['advisorId'])
                                             unset($_SESSION['advisorId']);
                                         if ($_SESSION['LPId'])
                                             unset($_SESSION['LPId']);
                                        
                                        mysql_data_seek($rsinvestor ,0);
                                        $count=mysql_num_rows($rsinvestor);
                                if($dealvalue==101)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            $Investorname=trim($myrow["Investor"]);
                                            $Investorname=strtolower($Investorname);

                                            $invResult=substr_count($Investorname,$searchString);
                                            $invResult1=substr_count($Investorname,$searchString1);
                                           $invResult2=substr_count($Investorname,$searchString2);
                                           if($newrowflag==1)
                                               echo "<tr><td  width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";

                                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                            {
                                             $_SESSION['investeeId'][$icount++] = $myrow["InvestorId"];
                                           //  $_SESSION['resultCompanyId'][$icount++] = $myrow["InvestorId"];
                                            if($dealvalue==6)
                                             {
                            ?><tr>
                                <td ><a class="postlink" href="dirinvdetails.php?value=<?php echo $myrow["InvestorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>"><?php echo $myrow["Investor"];?> </a></td></tr>
                            <?php
                                            $totalCount=$totalCount+1;
                                            }
                                            else
                                            {
                                            ?><tr>
                                <td ><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["InvestorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>"><?php echo $myrow["Investor"];?> </a></td></tr>
                            <?php    
                                            } 
                                            }
                                            
                                            $newrowflag=0;
                                            if($i==$rowlimit)
                                            {  
                                               $i=1;
                                               echo "</table></td>";
                                               if($count>$i && $columncount<$columnlimit)
                                               {

                                                   echo "<td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                               }
                                               elseif ($j==$count) 
                                               {
                                                   
                                                  echo "</table></td></tr>";
                                               }
                                            if($columncount==$columnlimit)
                                            {
                                                $columncount=1;
                                                $newrowflag=1;
                                            }
                                            else
                                            {

                                            $columncount++;
                                            }
                                            }
                                            elseif ($j==$count) 
                                            {
                                                  echo "</table></td></tr>";
                                            }
                                            else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                $i++;
                                            }
                                                    $j++;
                                       }
                                             if($columncount >= 4){
                                                 echo "</table></td></tr>";
                                                }
                                                
                                    }  
                                     else if($dealvalue==102)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $companyname=trim($myrow["companyname"]);
                                                $companyname=strtolower($companyname);

                                                $invResult=substr_count($companyname,$searchString);
                                                $invResult1=substr_count($companyname,$searchString1);
                                                $invResult2=substr_count($companyname,$searchString2);
                                               if($newrowflag==1)
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                   
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                    $_SESSION['resultCompanyId'][$icount++] = $myrow["PECompanyId"];
                                                   
                                   ?><tr>
                                       <td ><a class="postlink" href="companydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>/<?php echo $topNav; ?> "><?php echo $myrow["companyname"];?> </a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
                        
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                           }
                                     }
                                     else if($dealvalue==110)
                                     {
                                         $angelcoQuery = mysql_query($angelCosql);
                                         
                                         $totalAngelcount = mysql_num_rows($angelcoQuery);
                                         $Angelcount=0;
                                        While($myrow=mysql_fetch_array($angelcoQuery, MYSQL_BOTH))
                                        {
                                                $icount++;
                                                $Angelcount++;
                                                
                                               if($icount==1){
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                               }
                                                    $_SESSION['resultCompanyId'][$icount] = $myrow["angel_id"];
                                                    
                                                    
                                                    
                                                    if($myrow['PECompanyId']!='' && $myrow['PECompanyId']>0){
                                                        $data = "value=".$myrow['PECompanyId']."/$vcflagValue/110"; 
                                                    }
                                                    elseif($myrow['angel_id']!='' && $myrow['angel_id']>0){
                                                        $data = "value=".$myrow['angel_id']."/$vcflagValue/110&angelco_only"; 
                                                    }
                                                    
                                                    
                                                    if($Angelcount==1){
                                                        $detailurl = "companydetails.php?".$data;
                                                    }
                                                    
                                                    
                                                    if($myrow['angel_id']>0 )
                                                {
                                                   
                                   ?><tr>
                                    <td ><a class="postlink" href="companydetails.php?<?php echo $data;?> "><?php echo $myrow["company_name"];?> </a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
                                                
                                                if (($icount % 25) == 0)
                                                    { 
                                                     echo "</table></td> <td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                                    }
                                                
                                                    if(($icount % 100) == 0 ){
                                                         echo "</table></td>";
                                                         $icount=0;
                                                       
                                                        
                                                       // break;
                                                    }
                                                    if( $totalCount==$totalAngelcount){
                                                        
                                                         echo "</table></td></tr></td></tr>";   
                                                    }
                                                   
                        /*
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else { 
                                                    $i++;
                                                }
                                                        $j++;
                                                 * 
                                                 */
                                           }
                                     }
                                     else if($dealvalue==103 || $dealvalue==104)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $adviosrname=trim($myrow["Investor"]);
                                                $adviosrname=strtolower($adviosrname);

                                                $invResult=substr_count($adviosrname,$searchString);
                                                $invResult1=substr_count($adviosrname,$searchString1);
                                                $invResult2=substr_count($adviosrname,$searchString2);
                                                if($newrowflag==1)
                                                echo "<tr><td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";
                                                
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                        $_SESSION['advisorId'][$icount++] = $myrow["CIAId"];
                                                        $querystrvalue= $myrow["CIAId"];
                                         ?>
                                                        <tr><td>
                                                        <a class="postlink" style="text-decoration: none" href='diradvisor.php?value=<?php echo $querystrvalue;?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' >
                                                        <?php echo $myrow["Cianame"]; ?></a></td></tr>
                                                <?php
                                                        $totalCount=$totalCount+1;
                                                }
                                                 $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                        }
                                     }
                                     else if($dealvalue==105)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $adviosrname=trim($myrow["Incubator"]);
                                                $adviosrname=strtolower($adviosrname);

                                                $invResult=substr_count($adviosrname,$searchString);
                                                $invResult1=substr_count($adviosrname,$searchString1);
                                                $invResult2=substr_count($adviosrname,$searchString2);
                                                if($newrowflag==1)
                                                echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                                
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                        $_SESSION['IncubatorId'][$icount++] = $myrow["IncubatorId"];
                                         ?>
                                                        <tr><td>
                                                        <a style="text-decoration: none" href='dirincdetails.php?value=<?php echo $myrow["IncubatorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' >
                                                        <?php echo $myrow["Incubator"]; ?></a></td></tr>
                                                <?php
                                                        $totalCount=$totalCount+1;
                                                }
                                                 $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                        }
                                     }
                                     else if($dealvalue==106)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $companyname=trim($myrow["companyname"]);
                                                $companyname=strtolower($companyname);

                                                $invResult=substr_count($companyname,$searchString);
                                                $invResult1=substr_count($companyname,$searchString1);
                                                $invResult2=substr_count($companyname,$searchString2);
                                               if($newrowflag==1)
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                   
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                    $_SESSION['resultCompanyId'][$icount++] = $myrow["PECompanyId"];
                                                   
                                   ?><tr>
                                       <td ><a class="postlink" href="companydetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>/Directory "><?php echo $myrow["companyname"];?> </a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
                        
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                           }
                                     }
                                     else if($dealvalue==111)
                                     {

                                       /* if ($rsinvestors = mysql_query($getInvestorSqls)){
                                $investors_cnts = mysql_num_rows($rsinvestors);
                            }*/
                        
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                           /* print_r($myrow);
                                        exit();*/
                                                $companyname=trim($myrow["InstitutionName"]);
                                                $companyname=strtolower($companyname);

                                                $invResult=substr_count($companyname,$searchString);
                                                $invResult1=substr_count($companyname,$searchString1);
                                                $invResult2=substr_count($companyname,$searchString2);
                                               if($newrowflag==1)
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                   
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                    $_SESSION['LPId'][$icount++] = $myrow["LPId"];
                                                   
                                   ?><tr>
                                       <td ><a class="postlink lpalign" href="lpdirdetails.php?value=<?php echo $myrow["LPId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>/<?php echo $topNav; ?> ">
									   <?php //echo $myrow["InstitutionName"];?>

									   <?php 
									   if(strlen($myrow["InstitutionName"]) > 30 ) { 
									   echo substr($myrow["InstitutionName"],0,30).'...';
									   } else {
										echo substr($myrow["InstitutionName"],0,30);									   
									   }
									   ?>
									   
									   </a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
                        
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."%><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                           }
                                     }
                    
                        ?>
                                                        
                              </tbody>
                  </table>

<!-- Changes -->
<div class="other_db_search" >
        <div class="other_db_searchresult" style="<?php if ($totalno == 0) {echo "margin-top:20px;";}?>">
            <p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>
        </div>
    </div>
<!-- Changes -->
                       
                </div>  
        </div>
            
             
             
        
    </div>
<?php
                    }
                                        else
                                        {
                                            echo "NO DATA FOUND";
                                            if($searchallfield !="" || $dirsearch !=""){
                                            ?>
                                             <!-- Changes -->
<div class="other_db_search" style="display:block;">
        <div class="other_db_searchresult" style="<?php if ($totalno == 0) {echo "margin-top:20px;";}?>">
            <p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>
        </div>
    </div>
<!-- Changes -->
                                            <?php
                                        }
                                    }
                 
            ?>
   
    

   

            <?php  if($notable==false)  {  ?> 
             <div style="padding: 0 1%; margin-top: 20px">
             <div class="holder" style="float:none; text-align: center;">
                 <div class="paginate-wrapper" style="display: inline-block;"></div>
             </div>
             <?php
                    if(($exportToExcel==1))
                    {
                    ?>
                                    <span style="float:right; margin-right: 10px;" class="one title-links">
                                   <!--  <a class="export exlexport" id="expshowdeals" name="showprofile">Export</a> -->
                                    </span>

                                    <?php if($dealvalue == 101) { ?>
                                         <script type="text/javascript">
                                            $('#exportbtn').html('<a class ="export" onClick="open_ex(this)" data-check="close" id="expshowdeals" style="background: #a37635 url(/cfsnew/images/arrow-dropdown.png) no-repeat 90px 8px;width: 80px;">Export</a><div style="display:none;" class="exportinvest"><div class="with-invs exportdealsinvest" data-invs="0">With Investment</div><div class="without-invs exportdealsinvest" data-invs="1">W/O Investment</div></div>');
                                        </script>
                                    <?php } else { ?>
                                         <script type="text/javascript">
                                                $('#exportbtn').html('<a class ="export exportdealsinvest" id="expshowdeals" name="showprofile">Export</a>');
                                         </script>
                                   <?php } ?>
                    <?php
                    } ?>
                   
             </div>                
           <?php 
           }
           ?>
    
    
</td>




</tr>
</table>

    
<input type="hidden" name="searchallfield" id="searchallfield" value="<?php echo $searchallfield;?>" >
  
                     
</div>

</form>

    <?php if($dealvalue==101)
    {
      
    if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearch_legal!="" || $advisorsearch_trans!="" || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageidvalue!="" || (($round != "--") && ($round != "")) || $city!=""){
        
            if($vcflagValue!=2){ ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="exportinvestorprofile.php" >
                <input type="hidden" name="hiddenSearchKey" value="<?php echo $_GET['s']; ?>" >
                <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
                <input type="hidden" name="showprofile" id="showprofile" value="" >
           <?php  }else{  ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="angelallinvestorexport.php">
                <input type="hidden" name="hiddenexportall" value="1" >
                <input type="hidden" name="hiddenSearchKey" value="<?php echo $_GET['s']; ?>" >
                 <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
                 <input type="hidden" name="showprofile" id="showprofile" value="" >
           <?php  } ?>
             
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
            <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
            <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
            <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
            <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
            <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
            <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearch_legal;?>" >
            <input type="hidden" name="txthideadvisortrans" value="<?php echo $advisorsearch_trans;?>" >
            <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
            <input type="hidden" name="txthideround" value="<?php echo $round; ?>">
            <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
            <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
            <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
            <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>">
            <input type="hidden" name="hidecity" value="<?php echo $city;?>">

       <?php
       }
       else{
           if($vcflagValue!=2){ ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="exportinvestorprofile.php" >
                <input type="hidden" name="hiddenSearchKey" value="<?php echo $_GET['s']; ?>" >
                <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
                <input type="hidden" name="showprofile" id="showprofile" value="" >
           <?php  }else{  ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="angelallinvestorexport.php">
                <input type="hidden" name="hiddenexportall" value="1" >
                <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
                <input type="hidden" name="showprofile" id="showprofile" value="" >
           <?php  } ?>
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            
      <?php 
       }
    }
       else if($dealvalue==102)
       {
           if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearch_legal!="" || $advisorsearch_trans!="" || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageidvalue!=""){
        ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="exportcompaniesprofile.php">
                <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
                <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
                <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
                <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
                <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
                <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
                <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
                <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
                <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
                <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
                <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearch_legal;?>" >
                <input type="hidden" name="txthideadvisortrans" value="<?php echo $advisorsearch_trans;?>" >
                <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
                <input type="hidden" name="txthideround" value="<?php echo $round; ?>">
                <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
                <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
                <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
                <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
                <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>">
                <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >
   <?php
       }
       else{
          ?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportcompaniesprofile.php" >
            <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> > 
            <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    <?php
        }
    }
    else if($dealvalue==104 || $dealvalue==103)
    { 
        if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearch_legal!="" || $advisorsearch_trans!=""  || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageidvalue!="" || $tagsearch!=""){
        ?>

            <form name="pegetdata" id="pegetdata"  method="post" action="exportadvisortrans.php" >
            <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >    
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
            <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
            <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
            <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
            <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
            <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
            <input type="hidden" name="txthideadvisor" value="<?php echo $advisorsearch_trans;?>" >
            <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearch_legal;?>" >
            <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
            <input type="hidden" name="txthideround" value="<?php echo $round; ?>">
            <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
            <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
            <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
            <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>">
            <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >
            <input type="hidden" name="tagsearch" value="<?php echo $tagsearch;?>" > 

       <?php
       }
       else{
          ?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportadvisortrans.php" >
            <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >     
            <!--input type="hidden" name="hidepeipomandapage" value="<?php echo $dealvalue;?>" -->
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
            <input type="hidden" name="tagsearch" value="<?php echo $tagsearch;?>" > 
    <?php
        }
        
    }
    else if($dealvalue==105 || $dealvalue==106)
    {?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportincubation.php" >
            <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> > 
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >

   <?php }
    else
   if($dealvalue==111)
    {
      
    if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearch_legal!="" || $advisorsearch_trans!="" || $industry!="" || ($startRangeValue!="--" && $endRangeValue!="--") || $investorType!="" ||  ($dt1!="" && $dt2!="") || $stageidvalue!="" || (($round != "--") && ($round != "")) || $city!=""){
        
            if($vcflagValue!=2){ ?>
                <form name="pegetdata" id="pegetdata"  method="post" action="exportlimitedpartnersprofile.php" >
                    <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
                    <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >
                    <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
                    <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
                    <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
                    <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
                    <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
                    <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
                    <input type="hidden" name="txthidecompany" value="<?php echo $companysearch;?>" >
                    <input type="hidden" name="txthidesector" value="<?php echo $sectorsearch;?>" >
                    <input type="hidden" name="txthideadvisorlegal" value="<?php echo $advisorsearch_legal;?>" >
                    <input type="hidden" name="txthideadvisortrans" value="<?php echo $advisorsearch_trans;?>" >
                    <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
                    <input type="hidden" name="txthideround" value="<?php echo $round; ?>">
                    <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
                    <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
                    <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
                    <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
                    <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>">
                    <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >

       <?php
            }
            else{
          ?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportlimitedpartnersprofile.php" >
                <input type="hidden" name="sqlquery" value="<?php echo $exportsql; ?>" >
                <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> > 
                <input type="hidden" name="hidepeipomandapage" value="<?php echo $vcflagValue;?>" >
                <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
                <input type="hidden" name="hideShowAll" value="ShowAll" >
                <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
        <?php
        }
        }
       
    }
    ?>
            <input type="hidden" name="searchallfield" id="searchallfield" value="<?php echo $searchallfield;?>" >
            </form>

           
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
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
             <?php if(count($cityid) == 0 && count($countryNINtxt) == 0){ ?>
                <script type="text/javascript">
                    $('#country').val('');
                    // $('#city').select2();
                    // $('#city').select2().next().hide();
                    // $('#countryNIN').select2();
                    $('#city_div').hide();
                    $('#country_div').hide();
                    // $('#countryNIN').select2().next().hide();
                </script>
            <?php }  ?>
           

       <script type="text/javascript">
           
           $(document).ready(function() {
            <?php if($dealvalue == 101){ ?>
                $('#country').select2({ 
                    placeholder: "Search By Investor Location (Headquarters)",
                    minimumResultsForSearch: Infinity
                });
            <?php } else { ?>
                $('#country').select2({
                    placeholder: "Select Options",
                    minimumResultsForSearch: Infinity
                });
            <?php } ?>
            });
            $resulttag = $('.result-title').height();
            $resulttaglist = $('.result-select').height();
            if($resulttag > 200)
            {
            $('.result-title').addClass('resettag');
            $('.result-select').addClass('resettaglist');
            $('.list-tab').css('margin-top','120');
            }else
            {
            $('.result-title').removeClass('resettag');
            $('.result-select').removeClass('resettaglist');
            $('.list-tab').css('margin-top',$('.result-title').height()-55);
            }
           
           
           
                $("a.postlink").click(function(){
                 
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval); 
                    $("#pesearch").submit();
                    
                    return false;
                    
                });
                /*$('#expshowdeals,.exlexport').click(function(){ 
                    hrefval= 'exportinvestorprofile.php';
                    $("#pegetdata").submit();
                    return false;
        });*/
                
                function open_ex(element){
                    if ($(element).attr("data-check") == 'close') {
                        $(".exportinvest").show();
                        $(element).attr("data-check", "open");
                    }else if($(element).attr("data-check") == 'open'){
                        $(".exportinvest").hide();
                        $(element).attr("data-check", "close");
                    }else{
                        $(".exportinvest").hide();
                        $(element).attr("data-check", "close");
                    }
                }

                $('.exportdealsinvest').click(function(){ 
                    $("#showprofile").val($(this).attr("data-invs"));
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
                });
            
                // Multiple city edit
                var country_val = $('#country').val();
                if(country_val != ''){
                    $(".city_country_filter_btn").show();
                }
                // end multiple city
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
                   //alert(country);
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

                // $('#city').on('select2:close', function (e)
                // {   
                //     $('#pesearch').submit();
                // });
                // $('#countryNIN').on('select2:close', function (e)
                // {   
                //     $('#pesearch').submit();
                // });

                function initExport(){ 
                    
                        url = ($("#pegetdata").attr('action')=='exportinvestorprofile.php') ? 'exportinvestorprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='angelallinvestorexport.php') ? 'exportinvestorprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportcompaniesprofile.php') ? 'exportcompaniesprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportadvisorsprofile.php') ? 'exportadvisorsprofilecnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportadvisortrans.php') ? 'exportadvisortranscnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportincubation.php') ? 'exportincubationcnt.php' : '';
                        if (url=='')
                            url = ($("#pegetdata").attr('action')=='exportlimitedpartnersprofile.php') ? 'exportlimitedpartnersprofilecnt.php' : '';
                        $.ajax({
                            url: url ,
                            data: $("#pegetdata").serialize(),
                            type: 'POST',
                            success: function(data){
                                var currentRec = data;
                                
                                 if (currentRec > 0){
                                    $.ajax({
                                        url: 'ajxCheckDownload.php',
                                        dataType: 'json',
                                        success: function(data){
                                            var downloaded = data['recDownloaded'];
                                            var exportLimit = data.exportLimit;
                                            var remLimit = exportLimit-downloaded;
                                
                                            if (currentRec < remLimit){
                                                //hrefval= 'exportinvestorprofile.php';
                                                //$("#pegetdata").attr("action", hrefval);
                                                $("#pegetdata").submit();
                                            }else{
                                                jQuery('#preloading').fadeOut();
                                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                                            }
                                            jQuery('#preloading').fadeOut();
                                            
                                        },
                                        error:function(){
                                            jQuery('#preloading').fadeOut();
                                            alert("There was some problem exportings...");
                                        }

                                    });
                                }else{
                                    jQuery('#preloading').fadeOut();
                                    alert("There was some problem exportingss...");
                                }
                            },
                            error: function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem exportingsss...");
                            }
                        });
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

             $(".btn-slide").click(function(){
                if ($('.left-td-bg').css("min-width") == '264px') {
                    $('.tab-view-btn').css('margin-top','-18px');
                    $(".result-title").css('width','95%');
                } else {
                    if($(window).width() < 1600){
                        if($('.select2-selection--multiple').closest('.select2').hasClass('select2-container') || $('#select2-city-container').closest('.select2').hasClass('select2-container')){
                            if($('.select2-selection--multiple').closest('.select2').is(":hidden") == false || $('#select2-city-container').closest('.select2').is(":hidden") == false){
                                $('.tab-view-btn').css('margin-top','10px');
                               
                            }
                        }
                        if($('.selectgroup.countryNIN').is(":hidden") == false || $('.selectgroup.citysearch').is(":hidden") == false){
                            $('.tab-view-btn').css('margin-top','10px');
                        }
                        
                    }
                    $(".result-title").css('width','80%');
                }
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
    //         $(document).on('click','.request-for-lp',function(){
            
    //   jQuery('#maskscreen').fadeIn(1000);
    //   jQuery('#ymessage').val('');
    //   jQuery('#popup-box-lp').fadeIn();   
    //   return false;
    //  });
    //  $(document).on('click','#cancelbtn-lp',function(){
    
    //   jQuery('#maskscreen').fadeOut();
    //   jQuery('#popup-box-lp').fadeOut();   
    //   return false;
    //  });
    
   

            </script>
<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
<form id="other_db_submit" method="post" action="pedirview.php">
                <input type="hidden" name="searchallfield_other" id="other_searchallfield" value="<?php echo $searchallfield; ?>">
                <input type="hidden" name="companyauto_sug_other" id="companyauto_sug_other" value="<?php echo $companyauto; ?>">
                <input type="hidden" name="companysearch_other" id="companysearch_other" value="<?php echo $company_filter; ?>">
                <input type="hidden" name="investorauto_sug_other" id="investorauto_sug_other" value="<?php echo $investorauto; ?>">
                <input type="hidden" name="keywordsearch_other" id="keywordsearch_other" value="<?php echo $invester_filter; ?>">
                <input type="hidden" name="sectorsearch_other" id="sectorsearch_other" value="<?php echo $sectors_filter; ?>">
                <input type="hidden" name="advisorsearch_legal_other" id="advisorsearch_legal_other" value="<?php echo $advisorsearchstring_legal; ?>">
                <input type="hidden" name="advisorsearch_trans_other" id="advisorsearch_trans_other" value="<?php echo $advisorsearchstring_trans; ?>">
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
<!-- <div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-lp" style="    width: 450px;">
    <div class="title" style="font-size: 16px;"> Request for - LP Directory </div>
        <form style="margin-bottom: 0px;">
            <div class="entry">
                    <h5>Add a note..</h5><span style='float:right;display: block;margin-top: -20px;'></span>
                    <textarea name="ymessage" id="ymessage" style="width: 420px; height: 57px;" placeholder="For example, enter your phone number and convenient time for a call" val=''></textarea>
                    <input type="hidden" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"/>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn-lp" />
                <input type="button" value="Cancel" id="cancelbtn-lp" />
                <span style="padding: 3px 0px;">(Alternatively please call us at +91 44 42185180)</span>
            </div>

        </form>
    </div> -->
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




<?php if($angelCosql) { ?>
<script type="text/javascript"> 
$(document).ready(function(){
    $("#exportbtn, #expshowdeals").hide();
    $("#icon-detailed-view").attr('href','<?php echo $detailurl?>');
    
    
   
          $('.angelfilter').on('ifChecked', function(event){
              // alert('sdfdsds');
              
              $("#company_location, #raising_amount").val('');
              
              val = $('input[name=angelsearchtype]:checked').val();
              if(val==1){
                  $("#company_location").show();
                  $("#raising_amount").hide();
              }
               else if(val==2){
                  $("#raising_amount").show();
                  $("#company_location").hide();
              }
           });
           
    
    
    });
</script>
<?php } ?>







<script src="hopscotch.js"></script>
<?php if(isset($_SESSION['currenttour'])) { echo ' <script src="'.$_SESSION['currenttour'].'.js?24feb"></script> '; } ?>

<script type="text/javascript"> 
$(document).ready(function(){
    // $('#city').on("change",function(){
    //                 var citytotalcount = $('#city option').length; 
    //                   var citytotalcount_selected = $('#city option:selected').length;
                      
    //                       var allcityflag = 0;
    //                   if(citytotalcount == citytotalcount_selected)
    //                   {
                         
    //                      allcityflag = 0;
                          
                          
    //                       $("#cityflag").val(allcityflag);
                          
    //                   }
    //                   else{  allcityflag = 1;$("#cityflag").val(allcityflag);}
    //                 });
    //                 $('#countryNIN').on("change",function(){
    //                 var countryNINtotalcount = $('#countryNIN option').length; 
    //                   var countryNINtotalcount_selected = $('#countryNIN option:selected').length;
                      
    //                       var allcountryNINflag = 0;
    //                   if(countryNINtotalcount == countryNINtotalcount_selected)
    //                   {
                          
    //                      allcountryflag = 0;
                          
                          
    //                       $("#countryNINflag").val(allcountryNINflag);
                         
                          
    //                   }
    //                   else{  allcountryNINflag = 1;$("#countryNINflag").val(allcountryNINflag);
                       
    //                   }
    //                 });
    //                 $country_val_checked = $("#countryNINflag").val();
    //                 var countryNINtotalcount = $('#countryNIN option').length; 
    //                   var countryNINtotalcount_selected = $('#countryNIN option:selected').length;
    //                if(($country_val_checked == 0 ) && (countryNINtotalcount_selected > 0)){
    //                     $('#countryNIN option').prop('selected', true);
    //                     $("#countryNIN").multiselect('refresh');
    //                     $("#countryNINflag").val(1);
    //                 }

   <?php if(isset($_SESSION["DirectorydemoTour"]) && $_SESSION["DirectorydemoTour"]=='1') { ?>
        Directorydemotour=1;

         <?php if($_GET["value"]=='10'  && ($dealvalue=='103')  ){?>
               hopscotch.startTour(tour, 13);                            
         <?php }
         else if($_GET["value"]=='10' ){?>
               hopscotch.startTour(tour, 12);                            
         <?php } 
         else if($_GET["value"]=='0' && ($_POST["industry"]=='14')  ){?>
               hopscotch.startTour(tour, 9);                            
         <?php } 
         else if($_GET["value"]=='0'){?>
                 
               hopscotch.startTour(tour, 6);
                $(".hopscotch-bubble").hide();
                 
                        $('body,html').animate({  scrollTop: $(document).height()   }, 6000);
                           
                            setTimeout(function() {                              
                                if(Directorydemotour==1){ $('body,html').animate({scrollTop:0}, 6000);}                                  
                            },4000); 
                            
                            setTimeout(function() {
                                if(Directorydemotour==1)
                                {
                                    hopscotch.startTour(tour, 6); 
                                    var tourshake =  setInterval(function(){  
                                       if(hopscotch.getCurrStepNum()==6) { $(".tourboxshake").effect( "shake",{times:1}, 2000 ); }
                                   },5000); 
                                             
                                }                                   
                            },8000);                                            
         <?php }         
         else { ?>
                     
                hopscotch.startTour(tour,0); 
            <?php } ?>  


  <?php } ?>
      
      
        $('.ui-multiselect').attr('id','uimultiselect');    

           $("#uimultiselect, #uimultiselect span").click(function() {
                if(Directorydemotour==1)
                        {  showErrorDialog(warmsg); $('.ui-multiselect-menu').hide(); }     
            });
            
            
            
            


   });$tagradio=$('#tagradio').val();
if($tagradio==0){
    $('#and').prop('checked', true);
    $('#or').prop('checked', false);
    $('.cb-enable').addClass('selected');
    $('.cb-disable').removeClass('selected');

   
}else{
    $('#or').prop('checked', true);
    $('#and').prop('checked', false);
    $('.cb-disable').addClass('selected');
    $('.cb-enable').removeClass('selected');
}

   $(document).ready(function(){  
    $(".tagpopup").click(function(){
$('.overlayshowdow').show();
$('.overlaydiv').show();
        $("html, body").animate({ scrollTop: 0 }, "slow");
     });
$(".close,.overlayshowdow").click(function(){
    $('.overlayshowdow').hide();
    $('.overlaydiv').hide();
        
     });
        $(".cb-enable").click(function(){
            var parent = $(this).parents('.switchtag-and-or');
            $('.cb-disable',parent).removeClass('selected');
            $(this).addClass('selected');
            $('.checkbox',parent).attr('checked', true);
        });
           $(".cb-disable").click(function(){
            var parent = $(this).parents('.switchtag-and-or');
            $('.cb-enable',parent).removeClass('selected');
            $(this).addClass('selected');
            $('.checkbox',parent).attr('checked', false);
        });  
  });
   $("#tagsearch_auto").tokenInput("ajaxTagsearch.php",{
            theme: "facebook",
            minChars:2,
            queryParam: "pe_cq",
            hintText: "",
            noResultsText: "No Result Found",
            preventDuplicates: true,
            onAdd: function (item) {
                var tags="";
                var selectedValues = $('#tagsearch_auto').tokenInput("get");
                for (let index = 0; index < selectedValues.length; index++) {
                    tags += selectedValues[index].name;
                    tags += ',';
                }
                $('#tagsearch').attr("value","");
                $('#tagsearch_auto').attr("value",tags.substring(0,tags.length - 1));
            },
            onDelete: function (item) {
                    var selectedValues = $('#tagsearch_auto').tokenInput("get");
                    var inputCount = selectedValues.length;
                    var tags="";
                    if(inputCount==0){ 
                        $('#tagsearch_auto').val("");
                        $('#tagsearch').val("");
                    } else {
                        for (let index = 0; index < selectedValues.length; index++) {
                           tags += selectedValues[index].name;
                           tags += ',';
                        }
                        $('#tagsearch').attr("value","");
                        $('#tagsearch_auto').attr("value",tags.substring(0,tags.length - 1));
                        //$('#tagsearch').attr("value",tags.substring(0,tags.length - 1));
                    }
        },
            prePopulate :<?php if($tag_response!=''){echo   $tag_response; }else{ echo 'null'; } ?>
    });
    $('#mailbtn-lp').click(function(e){ 
                        e.preventDefault();
                       // if(checkEmail())
                       // {
                        $.ajax({
                            url: 'ajaxsendmailLP.php',
                             type: "POST",
                           /* data: { to : $("#toaddress").val(), ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },*/
                            data: { ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
                            success: function(data){
                                    if(data=="1"){
                                         alert("Mail Sent Successfully");
                                        jQuery('#popup-box-lp').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);
                                   
                                }else{
                                    jQuery('#popup-box-lp').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);
                                    alert("Try Again");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem sending mail...");
                            }

                        });
                       // }
                        return false;
                    });
// AjaxData
$(".other_db_search").on('click', '.other_db_link', function() {
    var search_val = $(this).attr('data-search_val');
   // $('input[name="searchallfield"]').val(search_val);
   $('#all_keyword_other').val(search_val);
});

$(document).ready(function(){

// multiple city edit
// $country_valu = $('#country').val();
// if($country_valu == ''){
//     $('#city').select2();
//     $('#city').select2().next().hide();
//     $('#countryNIN').select2();
//     $('#countryNIN').select2().next().hide();
// }
// end test



    var search_filter= "";
    var search_valid="";
    $searchallfield = $("#searchallfield").val();
    $dirsearch = $("#autocomplete").val();
   if($searchallfield !=""){
            search_filter = $("#searchallfield").val();
            search_valid=0;
            }
    else if($dirsearch !=""){
                search_filter = $("#autocomplete").val();
                search_valid=1;
            }
    $.ajax({
        url: 'pedirview_related_datas.php',
        type: "POST",
        dataType: "JSON",
        data: { 
            dirview_type : <?php echo $_GET['value']; ?>,
            search_valid : search_valid,
            searchallfield : search_filter,
            filed_name : $("input[name='showdeals']:checked").val(),
            tour_month1 :  $("#tour_month1").val(),
            tour_year1 :  $("#tour_year1").val(),
            tour_month2 :  $("#tour_month2").val(),
            tour_year2 :  $("#tour_year2").val(),
            investments : $("input[name='investments']:checked").val()
        },
        success: function(data){
           var html='';
            html += data.message+' ';
            console.log(data);
            if(data.result ==1){
                var count=1;
                 $.each( data.sections, function( key, value ) {
                        html += value.html;
                   count++;
                  });
                  $('.other_db_search').fadeIn();
                  setTimeout(function() {
                    $('.other_db_searchresult').html(html);
                }, 3000);
                  
            }else{
                 $('.other_db_searchresult').html('<p class="other_loading">No matching results found in other databases.</p>');
                 $('.other_db_search').fadeOut(10000);
            }
        },
        error:function(){
            jQuery('#preloading').fadeOut();
            alert("Something went wrong...");
        }
    });
    return false;

    $(".other_db_link").live( "click", function() {
        var href = $(this).attr('href');
        var searchValue = $(this).attr('data-value');
        $('#other_searchallfield').val(searchValue);
        $('#other_db_submit').attr('action',href);
        $('#other_db_submit').submit();

        return false;
    });
});



</script>
<script type="text/javascript">
 
$(document).ready(function(){
$(function(){
	$(".selectgroup select").multiselect();
    $(".selectgroup #city, .selectgroup #countryNIN").multiselect({ noneSelectedText: 'Select options', selectedList: 0}).multiselectfilter();

});
});
</script>


<?php
mysql_close();
    mysql_close($cnx);
?>